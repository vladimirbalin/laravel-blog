<?php

namespace App\Notifications;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class BlogPostLikedNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    public $post;
    public $liker;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(BlogPost $post, User $user)
    {
        $this->post = $post;
        $this->liker = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'post_id' => $this->post->id,
            'liker_name' => $this->liker->name
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'data' => [
                'post_id' => $this->post->id,
                'liker_name' => $this->liker->name
            ]
        ];
    }

    public function broadcastOn()
    {
        return new PrivateChannel("user.{$this->post->user_id}");
    }
}
