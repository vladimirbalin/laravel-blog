<?php

namespace App\Listeners;

use App\Events\UserFollowedEvent;
use App\Notifications\UserFollowedNotification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserFollowedListener
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
     * @param UserFollowedEvent $event
     * @return void
     */
    public function handle(UserFollowedEvent $event)
    {
        $followed = $event->followedUser;
        $followed->notify(new UserFollowedNotification($event->currentUser, $event->followedUser));
    }

}
