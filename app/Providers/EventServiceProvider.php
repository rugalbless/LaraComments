<?php

namespace App\Providers;

use App\Events\CommentCreatedEvent;
use App\Listeners\SendCommentCreatedNotifications;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{


    protected $listen = [

        CommentCreatedEvent::class => [
            SendCommentCreatedNotifications::class,
        ],

        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

    ];




    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
