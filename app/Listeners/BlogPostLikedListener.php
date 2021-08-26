<?php

namespace App\Listeners;

use App\Events\BlogPostLikedEvent;
use App\Notifications\BlogPostLikedNotification;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

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
    public function handle(BlogPostLikedEvent $event)
    {
        $postAuthor = $event->post->user;
        $postAuthor->notify(new BlogPostLikedNotification($event->post, $event->user));
    }

}
