<?php

namespace App\Listeners;

use App\Events\BlogPostLikedEvent;
use App\Notifications\BlogPostLikedNotification;

class BlogPostLikedListener
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
     * @param BlogPostLikedEvent $event
     * @return void
     */
    public function handle(BlogPostLikedEvent $event): void
    {
        $postAuthor = $event->post->user;
        $postAuthor->notify(new BlogPostLikedNotification($event->post, $event->user));
    }

}
