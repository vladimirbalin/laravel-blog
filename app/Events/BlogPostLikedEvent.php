<?php

namespace App\Events;

use App\Models\BlogPost;
use App\Models\User;

class BlogPostLikedEvent
{
    public $post;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(BlogPost $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

}
