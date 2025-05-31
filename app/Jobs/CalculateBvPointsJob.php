<?php

namespace App\Jobs;

use App\Enums\BinaryPlaceEnum;
use App\Events\UserReachedDailyMaxOut;
use App\Models\BvPointEarning;
use App\Models\BvPointReward;
use App\Models\Earning;
use App\Models\MaxedOutBvPoint;
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
        // $bv_points = config('genealogy.bv_points.balance_rewards', []);

        // Fetch the package and user
        $package = $this->package;
        $purchasedUser = $this->user;

        $package->refresh();
        if ($package->bvPointEarning()->exists()) {
            Log::channel('bv-points')->warning("Purchased Package Already BV Points earned! (" . date('Y-m-d') . "). | Package: " . $package->id . " Purchased Date: " . $package->created_at . " | User: " . $package->user->username . "-" . $package->user_id);
            return;
        }
        try {
            Log::channel('bv-points')->notice("Calculate Bv Points Job started. | Package: " . $package->id . " Purchased Date: " . $package->created_at . " | User: " . $package->user->username . "-" . $package->user_id);

            \DB::transaction(function () use ($package, $purchasedUser) {
                $step = 20; // Pattern increment step (20, 40, 60, ...)
                $usdValueIncrement = 7; // USD increment for each step

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
                    $pointEarning = BVPointEarning::create([
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

                    // Get the maximum usable points that fit the pattern
                    $usablePoints = min(
                        floor($parent->left_points_balance / $step) * $step,
                        floor($parent->right_points_balance / $step) * $step
                    );

                    // Remaining points
                    $remainingLeft = $parent->left_points_balance % $step;
                    $remainingRight = $parent->right_points_balance % $step;

                    // Calculate USD value for the usable points
                    $usdValue = ($usablePoints / $step) * $usdValueIncrement;

                    Log::channel('bv-points')->info("User: {$parent->id} Balanced Points = $usablePoints, USD Value = $usdValue");
                    Log::channel('bv-points')->info("User: {$parent->id} Remaining Left Points = $remainingLeft, Remaining Right Points = $remainingRight");

                    if ($usablePoints >= $step && $usdValue >= $usdValueIncrement) {
                        //foreach (array_reverse($bv_points, true) as $usablePoints => $usdValue) {
                        if ($parent->left_points_balance >= $usablePoints && $parent->right_points_balance >= $usablePoints) {

                            $isQualified = $parent->is_active;

                            // Create a reward record
                            $reward = BvPointReward::create([
                                'bv_point_earning_id' => $pointEarning->id,
                                'user_id' => $parent->id,
                                'purchased_package_id' => $package->id,
                                'level_user_id' => $purchasedUser->id,
                                'bv_points' => $usablePoints,
                                'amount' => $usdValue,
                                'paid' => 0,
                                'status' => $isQualified ? 'pending' : 'expired'
                            ]);

                            $usdValue_left = $isQualified ? 0 : $usdValue;

                            // Decrement the left and right BV points
                            $parent->decrement('left_points_balance', $usablePoints);
                            $parent->decrement('right_points_balance', $usablePoints);

                            if ($isQualified) {

                                $daily_max_out_limit = $parent->effective_daily_max_out_limit; // get the highest daily max out limit from the user active packages'
                                $BvUserActivePackages = $parent->activePackages;

                                $today_earnings_for_active_package = Earning::where('user_id', $reward->user_id)
                                    //->where('purchased_package_id', $activePackage->id)
                                    ->whereDate('created_at', date('Y-m-d'))
                                    ->whereIn('status', ['RECEIVED', 'HOLD'])
                                    ->whereNotIn('type', ['RANK_BONUS', 'RANK_GIFT', 'P2P', 'STAKING']) // 'PACKAGE','DIRECT','INDIRECT','BV','RANK_BONUS','RANK_GIFT','P2P','STAKING'
                                    ->sum('amount');

                                foreach ($BvUserActivePackages as $activePackage) {
                                    // $daily_max_out_limit = $activePackage->daily_max_out_limit ?? $activePackage->packageRef->daily_max_out_limit;

                                    Log::channel('max-out-log')->info(
                                        "Package {$activePackage->id} | " .
                                        "Max out limit: {$daily_max_out_limit}. | " .
                                        "Today(" . date('Y-m-d') . ") Earnings: {$today_earnings_for_active_package}. | " .
                                        "Package Ref Max out Limit: {$activePackage->packageRef->daily_max_out_limit}. | " .
                                        "Purchased Date: {$activePackage->created_at} | " .
                                        "User: {$activePackage->user->username} - {$activePackage->user_id}");


                                    if ($today_earnings_for_active_package >= $daily_max_out_limit) {
                                        Log::channel('max-out-log')->warning("No BV earnings recorded because of max out limit {$daily_max_out_limit} exceeded today(" . date('Y-m-d') . ") max out limit {$today_earnings_for_active_package}. | " .
                                            "Package {$activePackage->id} | " .
                                            "User: {$activePackage->user->username} - {$activePackage->user_id} ");

                                        event(new UserReachedDailyMaxOut($parent, $activePackage, "BV Point Earnings: Daily max limit of {$daily_max_out_limit} exceeded"));

                                        Log::channel('max-out-log')->warning("BREAKING THE LOOP");

                                        break;
                                    }

                                    $already_earned_percentage = $activePackage->earned_profit;

                                    $total_already_earned_income = ($activePackage->invested_amount / 100) * $already_earned_percentage;
                                    $total_allowed_income = ($activePackage->invested_amount / 100) * $activePackage->total_profit_percentage;

                                    // TODO: BUG $total_allowed_income is not accurate, use commission amount instead and fix
                                    $remaining_income = $total_allowed_income - $total_already_earned_income;
                                    if ($usdValue > $remaining_income) {
                                        $activePackage->update(['status' => 'EXPIRED']);
                                        Log::channel('bv-points')->info(
                                            "Package {$activePackage->id} | " .
                                            "COMPLETED {$total_already_earned_income}. | " .
                                            "CALCULATE BV TOTAL_ALLOWED_INCOME: {$total_allowed_income}. | " .
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

                                    $today_remaining_income = $daily_max_out_limit - $today_earnings_for_active_package;
                                    // Zero out BV Points
                                    if ($usdValue >= $today_remaining_income) {
                                        event(new UserReachedDailyMaxOut($parent, $activePackage, "BV Point Earnings: Daily max limit of {$daily_max_out_limit} exceeded"));
                                    }
                                    if ($usdValue > $today_remaining_income) {
                                        $can_today_paid_bv_reward_amount = $today_remaining_income;

                                        Log::channel('max-out-log')->info("Package {$activePackage->id} | LOGIC: $usdValue > $today_remaining_income |" .
                                            "CAN_TODAY_PAID_BV_REWARD_AMOUNT: $can_today_paid_bv_reward_amount | User: {$activePackage->user->username} - {$activePackage->user_id}");

                                        Log::channel('max-out-log')->debug("Package {$activePackage->id} | USDT VALUE: $usdValue | USD VALUE LEFT: $usdValue_left");

                                        if ($can_today_paid_bv_reward_amount <= 0) {
                                            Log::channel('max-out-log')->warning("BREAKING THE LOOP: Package {$activePackage->id} | CAN_TODAY_PAID_BV_REWARD_AMOUNT: <= 0");
                                            break;
                                        }

                                        $usdValue_left += ($usdValue - $can_today_paid_bv_reward_amount);
                                        $usdValue = $can_today_paid_bv_reward_amount;

                                        Log::channel('max-out-log')->debug("Package {$activePackage->id} | USDT VALUE: $usdValue | USD VALUE LEFT: $usdValue_left");
                                    }

                                    $earning = $reward->earnings()->save(Earning::forceCreate([
                                        'user_id' => $reward->user_id,
                                        'level_user_id' => $purchasedUser->id,
                                        // 'income_level' => null,
                                        'purchased_package_id' => $activePackage->id,
                                        'amount' => $usdValue,
                                        // 'payed_percentage' => null,
                                        'type' => "BV",
                                        'status' => 'HOLD',
                                    ]));

                                    $reward->increment('paid', $usdValue);

                                    $total_already_earned_income = $activePackage->total_earned_profit + $usdValue;
                                    $total_already_earned_income_percentage = ($total_already_earned_income / $activePackage->total_profit) * 100;
                                    $total_already_earned_income_percentage_from_profit_percentage = ($total_already_earned_income_percentage / 100) * $activePackage->total_profit_percentage;

                                    $activePackage->update(['earned_profit' => $total_already_earned_income_percentage_from_profit_percentage]);

                                    if ($activePackage->total_profit <= ($total_already_earned_income)) {
                                        $activePackage->update(['status' => 'EXPIRED']);
                                        Log::channel('bv-points')->info(
                                            "Package {$activePackage->id} | " .
                                            "COMPLETED {$total_already_earned_income}. | " .
                                            "CALCULATE BV TOTAL_PROFIT: {$activePackage->total_profit}. | " .
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
                                    $reward->earnings()->where('status', 'HOLD')->update(['status' => 'RECEIVED']);
                                    $wallet->increment("balance", $reward->paid);
                                }
                            }

                            if (!$isQualified || $usdValue_left > 0) {
                                $reward->refresh();
                                if ($usdValue_left !== $reward->amount) { // only add new record if reward qualified and left due to insufficient package-profit limit
                                    BvPointReward::forceCreate([
                                        'parent_id' => $reward->id,
                                        'user_id' => $parent->id,
                                        'bv_points' => $usablePoints,
                                        'amount' => $usdValue_left,
                                        'paid' => 0,
                                        'status' => 'expired'
                                    ]);
                                }

                            }

                            if ($reward->paid <= 0) {
                                $reward->update(['status' => 'expired']);
                            }
                            // Break the loop after issuing the highest possible reward
                            // continue; // TODO: use continue or break after discussed the client requirement. for now assumed the all possible rewards are issued if criteria met
                        } else {
                            // Log that no reward was issued for this parent
                            Log::channel('bv-points')->info("No reward issued for user {$parent->id} due to insufficient balanced points.", [
                                $parent->left_points_balance,
                                $parent->right_points_balance
                            ]);
                        }
                        //}
                    }

                    // Move to the next parent
                    $currentUser = $parent;
                }
            });
        } catch (\Throwable|\Exception|\Error $e) {
            Log::channel('bv-points')->error($e->getMessage() . " | Package: " . $package->id . " Purchased Date: " . $package->created_at . " | User: " . $package->user->username . "-" . $package->user_id);
        }

        Log::channel('bv-points')->info("CalculateBvPointsJob exited");
    }
}
