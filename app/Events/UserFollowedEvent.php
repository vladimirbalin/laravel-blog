<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserFollowedEvent
{
    public $currentUser;
    public $followedUser;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $currentUser, User $followedUser)
    {
        $this->currentUser = $currentUser;
        $this->followedUser = $followedUser;
    }

}
