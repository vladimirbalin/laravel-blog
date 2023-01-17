<?php

namespace App\Listeners;

use App\Events\UserFollowedEvent;
use App\Notifications\UserFollowedNotification;

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
    public function handle(UserFollowedEvent $event): void
    {
        $followed = $event->followedUser;
        $followed->notify(new UserFollowedNotification($event->currentUser, $event->followedUser));
    }

}
