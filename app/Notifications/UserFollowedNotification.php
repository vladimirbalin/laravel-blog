<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class UserFollowedNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    public $follower;
    public $followedUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $follower, User $followedUser)
    {
        $this->follower = $follower;
        $this->followedUser = $followedUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'data' => [
                'follower_id' => $this->follower->id,
                'follower_name' => $this->follower->name
            ]
        ];
    }

    public function broadcastOn()
    {
        return new PrivateChannel("user.{$this->followedUser->id}");
    }
}
