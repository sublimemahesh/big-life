<?php

namespace App\Jobs;

use App\Enums\BinaryPlaceEnum;
use App\Models\BvPointEarning;
use App\Models\BvPointReward;
use App\Models\PurchasedPackage;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Log;

class CalculateBvPointsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected User $user, protected PurchasedPackage $package)
    {
        //
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $bv_points = config('genealogy.bv_points.balance_rewards', []);

        // Fetch the package and user
        $package = $this->package;
        $purchasedUser = $this->user;

        $package->refresh();
        if ($package->bvPointEarning()->exists()) {
            logger()->warning("Purchased Package Already BV Points earned! (" . date('Y-m-d') . "). | Package: " . $package->id . " Purchased Date: " . $package->created_at . " | User: " . $package->user->username . "-" . $package->user_id);
            return;
        }
        try {
            logger()->notice("Calculate Bv Points Job started. | Package: " . $package->id . " Purchased Date: " . $package->created_at . " | User: " . $package->user->username . "-" . $package->user_id);

            \DB::transaction(function () use ($bv_points, $package, $purchasedUser) {

                // Traverse the genealogy tree and issue BV points
                $currentUser = $purchasedUser;
                while ($currentUser->parent_id !== null) {
                    $parent = $currentUser->parent instanceof User ? $currentUser->parent : User::find($currentUser->parent_id);

                    // Determine the side (left or right) based on the user's position
                    $left_side_point = 0;
                    $right_side_point = 0;
                    if (BinaryPlaceEnum::from($currentUser->position) === BinaryPlaceEnum::LEFT) {
                        $left_side_point = $package->packageRef->bv_points;
                        $parent->increment('left_points_balance', $left_side_point);
                    } else {
                        $right_side_point = $package->packageRef->bv_points;
                        $parent->increment('right_points_balance', $right_side_point);
                    }

                    // Create a point earning record
                    BVPointEarning::create([
                        "user_id" => $parent->id,
                        "purchased_package_id" => $package->id,
                        "purchaser_id" => $purchasedUser->id,
                        "left_point" => $left_side_point ?? 0,
                        "right_point" => $right_side_point ?? 0,
                    ]);

                    $parent->refresh();
                    $wallet = Wallet::firstOrCreate(
                        ['user_id' => $parent->id],
                        ['balance' => 0]
                    );
                    // Check for the highest possible balanced BV points and issue rewards
                    $left_children_count = $parent->directSales()->where('position', BinaryPlaceEnum::LEFT->value)->count();
                    $right_children_count = $parent->directSales()->where('position', BinaryPlaceEnum::RIGHT->value)->count();

                    $eligibility = $left_children_count > 0 && $right_children_count > 0 ? 'claimed' : 'pending';

                    foreach (array_reverse($bv_points, true) as $points => $usdValue) {
                        if ($parent->left_points_balance >= $points && $parent->right_points_balance >= $points) {

                            $isQualified = $parent->is_active;

                            // Create a reward record
                            $reward = BvPointReward::create([
                                'user_id' => $parent->id,
                                'bv_points' => $points,
                                'amount' => $usdValue,
                                'paid' => 0,
                                'status' => $isQualified ? 'pending' : 'expired'
                            ]);

                            $usdValue_left = $isQualified ? 0 : $usdValue;

                            // Decrement the left and right BV points
                            $parent->decrement('left_points_balance', $points);
                            $parent->decrement('right_points_balance', $points);

                            if ($isQualified) {

                                $BvUserActivePackages = $parent->activePackages;
                                foreach ($BvUserActivePackages as $activePackage) {
                                    $already_earned_percentage = $activePackage->earned_profit;

                                    $total_already_earned_income = ($activePackage->invested_amount / 100) * $already_earned_percentage;
                                    $total_allowed_income = ($activePackage->invested_amount / 100) * $activePackage->total_profit_percentage;

                                    // TODO: BUG $total_allowed_income is not accurate, use commission amount instead and fix
                                    $remaining_income = $total_allowed_income - $total_already_earned_income;
                                    if ($usdValue > $remaining_income) {
                                        $activePackage->update(['status' => 'EXPIRED']);
                                        Log::channel('daily')->info(
                                            "Package {$activePackage->id} | " .
                                            "COMPLETED {$total_already_earned_income}. | " .
                                            "Purchased Date: {$activePackage->created_at} | " .
                                            "User: {$activePackage->user->username} - {$activePackage->user_id}");

                                        $can_paid_bv_reward_amount = $remaining_income;
                                        if ($can_paid_bv_reward_amount <= 0) {
                                            continue;
                                        }
                                        $usdValue_left = $usdValue - $can_paid_bv_reward_amount;
                                        $usdValue = $can_paid_bv_reward_amount;
                                    } else {
                                        $usdValue_left = 0;
                                    }

                                    $reward->increment('paid', $usdValue);

                                    $total_already_earned_income = $activePackage->total_earned_profit + $usdValue;
                                    $total_already_earned_income_percentage = ($total_already_earned_income / $activePackage->total_profit) * 100;
                                    $total_already_earned_income_percentage_from_profit_percentage = ($total_already_earned_income_percentage / 100) * $activePackage->total_profit_percentage;

                                    $activePackage->update(['earned_profit' => $total_already_earned_income_percentage_from_profit_percentage]);

                                    if ($activePackage->total_profit <= ($total_already_earned_income)) {
                                        $activePackage->update(['status' => 'EXPIRED']);
                                        Log::channel('daily')->info(
                                            "Package {$activePackage->id} | " .
                                            "COMPLETED {$total_already_earned_income}. | " .
                                            "Purchased Date: {$activePackage->created_at} | " .
                                            "User: {$activePackage->user->username} - {$activePackage->user_id}");
                                    }
                                    if ($usdValue_left <= 0) {
                                        break;
                                    }
                                    $usdValue = $usdValue_left;
                                }

                                $reward->update(['status' => $eligibility]);
                                $reward->refresh();
                                if ($reward->status === 'claimed') {
                                    // Issue USD reward to the parent's wallet
                                    $wallet->increment("balance", $reward->paid);
                                }
                            }

                            if (!$isQualified || $usdValue_left > 0) {
                                if ($usdValue_left !== $reward->amount) { // only add new record if reward qualified and left due to insufficient package-profit limit
                                    BvPointReward::forceCreate([
                                        'parent_id' => $reward->id,
                                        'user_id' => $parent->id,
                                        'bv_points' => $points,
                                        'amount' => $usdValue_left,
                                        'paid' => 0,
                                        'status' => 'expired'
                                    ]);
                                }
                            }
                            // Break the loop after issuing the highest possible reward
                            continue; // TODO: use continue or break after discussed the client requirement. for now assumed the all possible rewards are issued if criteria met
                        }

                        // Log that no reward was issued for this parent
                        Log::info("No reward issued for user {$parent->id} due to insufficient balanced points.", [
                            $parent->left_points_balance,
                            $parent->right_points_balance
                        ]);
                    }

                    // Move to the next parent
                    $currentUser = $parent;
                }
            });
        } catch (\Throwable|\Exception|\Error $e) {
            logger()->error($e->getMessage() . " | Package: " . $package->id . " Purchased Date: " . $package->created_at . " | User: " . $package->user->username . "-" . $package->user_id);
        }
    }
}
