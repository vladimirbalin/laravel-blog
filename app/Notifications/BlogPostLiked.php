<?php

namespace App\Notifications;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class BlogPostLiked extends Notification implements ShouldQueue
{
    use Queueable;

    public $post;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(BlogPost $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'post_id' => $this->post->id,
            'who_liked' => $this->user->name
        ];
    }
}
