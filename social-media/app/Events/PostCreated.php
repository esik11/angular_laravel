<?php

namespace App\Events;

use App\Models\Post;
use App\Events\NotificationSent; // Import the NotificationSent event
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;

        // Trigger a notification for the user who created the post
        event(new NotificationSent([
            'user_id' => $this->post->user_id, // Assuming this is the post owner's user ID
            'message' => 'New post created!',
            'post_id' => $this->post->id,
        ]));
    }

    public function broadcastOn()
    {
        return new Channel('posts');
    }

    public function broadcastWith()
    {
        return [
            'post' => $this->post->load('user'),
        ];
    }
}
