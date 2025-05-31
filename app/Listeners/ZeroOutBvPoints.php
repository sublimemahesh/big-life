<?php

namespace App\Listeners;

use App\Events\UserReachedDailyMaxOut;
use App\Models\MaxedOutBvPoint;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

class ZeroOutBvPoints
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param UserReachedDailyMaxOut $event
     * @return void
     */
    public function handle(UserReachedDailyMaxOut $event): void
    {
        $parent = $event->user;
        $activePackage = $event->highestActivePackage;

        Log::channel('max-out-log')->info("Zeroing out BV points for user {$parent->id} as daily max limit exceeded on highest active package {$activePackage->id}");

        // Store current values for logging
        $previousLeftPoints = $parent->left_points_balance;
        $previousRightPoints = $parent->right_points_balance;

        // Zero out both left and right BV points
        $parent->update([
            'left_points_balance' => 0,
            'right_points_balance' => 0
        ]);

        // Store the maxed out BV points in the database
        MaxedOutBvPoint::create([
            'user_id' => $parent->id,
            'purchased_package_id' => $activePackage->id,
            'left_point' => $previousLeftPoints,
            'right_point' => $previousRightPoints,
            'maxed_out_date' => now()->format('Y-m-d'),
            'reason' => $event->reason
        ]);

        Log::channel('max-out-log')->info("BV points zeroed out for user {$parent->id}. Previous values: Left: {$previousLeftPoints}, Right: {$previousRightPoints}");
    }
}
