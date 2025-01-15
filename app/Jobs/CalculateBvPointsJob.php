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

class CalculateBvPointsJob implements ShouldQueue, ShouldBeUnique
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

    public function middleware()
    {
        return [(new WithoutOverlapping($this->package->id))->releaseAfter(60)];
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
                    $parent = $currentUser->parent instanceof User ? $currentUser->parent : null;

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

                            // Create a reward record
                            $reward = BvPointReward::create([
                                'user_id' => $parent->id,
                                'bv_points' => $points,
                                'amount' => $usdValue,
                                'status' => $eligibility,
                            ]);

                            if ($reward->status === 'claimed') {
                                // Issue USD reward to the parent's wallet
                                $wallet->increment("balance", $usdValue);
                            }

                            // Decrement the left and right BV points
                            $parent->decrement('left_points_balance', $points);
                            $parent->decrement('right_points_balance', $points);

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
