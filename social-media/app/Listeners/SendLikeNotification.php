<?php

namespace App\Listeners;

use App\Events\LikeAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Notification;
class SendLikeNotification implements ShouldQueue
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
     * @param  \App\Events\LikeAdded  $event
     * @return void
     */
    public function handle(LikeAdded $event)
    {
        Notification::create([
            'user_id' => $event->post->user_id,  // Notify the owner of the post
            'post_id' => $event->post->id,
            'type' => 'like',
            'is_read' => false,
        ]);
    }
}
