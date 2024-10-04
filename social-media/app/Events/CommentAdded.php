<?php

namespace App\Events;

use App\Models\Comment;
use App\Events\NotificationSent; // Import the NotificationSent event
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class CommentAdded implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;

        // Trigger a notification for the user whose post was commented on
        event(new NotificationSent([
            'user_id' => $this->comment->post->user_id, // Assuming the post owner should receive the notification
            'message' => 'New comment on your post!',
            'post_id' => $this->comment->post_id,
        ]));
    }

    public function broadcastOn()
    {
        return new Channel('posts');
    }

    public function broadcastWith()
    {
        return [
            'comment' => $this->comment->load('user'),
            'post_id' => $this->comment->post_id,
        ];
    }
}
