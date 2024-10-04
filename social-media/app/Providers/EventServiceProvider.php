<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

// Import the events and listeners
use App\Events\CommentAdded;
use App\Events\LikeAdded;
use App\Events\PostCreated;
use App\Listeners\SendCommentNotification;
use App\Listeners\SendLikeNotification;
use App\Listeners\SendPostNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        // Register listeners for CommentAdded event
        CommentAdded::class => [
            SendCommentNotification::class,  // This listener will handle comment notifications
        ],

        // Register listeners for LikeAdded event
        LikeAdded::class => [
            SendLikeNotification::class,     // This listener will handle like notifications
        ],

        // Register listeners for PostCreated event
        PostCreated::class => [
            SendPostNotification::class,     // This listener will handle post notifications
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Custom event bindings, if necessary
    }
}
