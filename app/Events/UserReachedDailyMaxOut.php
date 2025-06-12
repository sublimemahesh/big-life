<?php

namespace App\Events;

use App\Models\PurchasedPackage;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserReachedDailyMaxOut
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public User $user, public PurchasedPackage $highestActivePackage, public string $reason = 'Daily max limit exceeded')
    {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
