<?php

namespace App\Listeners;

use App\Events\PostCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Notification;

class SendPostNotification implements ShouldQueue
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
     * @param  \App\Events\PostCreated  $event
     * @return void
     */
    public function handle(PostCreated $event)
    {
        // Logic for post notifications (e.g., notify followers of the post creator)
        // Example:
        Notification::create([
            'user_id' => $event->post->user_id,  // Notify the owner of the post
            'post_id' => $event->post->id,
            'type' => 'post',
            'is_read' => false,
        ]);
    }
}
