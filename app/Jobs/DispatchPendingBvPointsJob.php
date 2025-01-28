<?php

namespace App\Jobs;

use App\Enums\BinaryPlaceEnum;
use App\Models\BvPointReward;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class DispatchPendingBvPointsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
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
        BvPointReward::where('status', 'pending')
            ->whereNull('parent_id')
            ->with('user')
            // ->withCount([
            //     'user.directSales as left_direct_sales_count' => function (Builder $query) {
            //         $query->where('position', BinaryPlaceEnum::LEFT->value);
            //     },
            //     'user.directSales as right_direct_sales_count' => function (Builder $query) {
            //         $query->where('position', BinaryPlaceEnum::RIGHT->value);
            //     }
            // ])
            ->whereHas('user', function (Builder $query) {
                // Ensure the user has at least one direct left child and one direct right child
                $query->whereRelation('directSales', 'position', BinaryPlaceEnum::LEFT->value)
                    ->whereRelation('directSales', 'position', BinaryPlaceEnum::RIGHT->value);
            })
            ->chunkById(100, function ($rewards) {
                foreach ($rewards as $reward) {
                    try {
                        // Fetch the user and their wallet
                        $user = $reward->user instanceof User ? $reward->user : User::find($reward->user_id);
                        $reward_user_wallet = $user->wallet();

                        $left_children_count = $user->directSales()->where('position', BinaryPlaceEnum::LEFT->value)->count();
                        $right_children_count = $user->directSales()->where('position', BinaryPlaceEnum::RIGHT->value)->count();

                        // $left_children_count = $reward->left_direct_sales_count;
                        // $right_children_count = $reward->right_direct_sales_count;

                        Log::channel('bv-points')->info("Reward {$user->id} user {$reward->id} direct sales count: ", [
                            'left_children_count' => $left_children_count,
                            'right_children_count' => $right_children_count,
                        ]);

                        $eligibility = $left_children_count > 0 && $right_children_count > 0 ? 'claimed' : 'pending';

                        // Check if the user still has sufficient direct sales
                        if ($eligibility === 'claimed') {
                            $reward_user_wallet->increment('balance', $reward->paid);
                            // Update the reward status to 'claimed'
                            $reward->update(['status' => 'claimed']);
                        }
                    } catch (\Exception $e) {
                        Log::channel('bv-points')->error("Failed to process reward for user {$reward->user_id}: " . $e->getMessage());
                    }
                }
            });
    }
}
