<?php

namespace App\Events;

use App\Models\User;

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
