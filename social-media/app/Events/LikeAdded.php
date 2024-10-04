<?php

namespace App\Events;

use App\Models\Like;
use App\Events\NotificationSent; // Import the NotificationSent event
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class LikeAdded implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $like;

    public function __construct(Like $like)
    {
        $this->like = $like;

        // Trigger a notification for the user whose post was liked
        event(new NotificationSent([
            'user_id' => $this->like->post->user_id, // Assuming the post owner should receive the notification
            'message' => 'Your post was liked!',
            'post_id' => $this->like->post_id,
        ]));
    }

    public function broadcastOn()
    {
        return new Channel('posts');
    }

    public function broadcastWith()
    {
        return [
            'like' => $this->like->load('user'),
            'post_id' => $this->like->post_id,
        ];
    }
}
