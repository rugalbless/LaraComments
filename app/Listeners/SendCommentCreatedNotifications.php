<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\CommentCreatedEvent;
use App\Models\User;
use App\Notifications\NewCommentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCommentCreatedNotifications
{

    public function handle(CommentCreatedEvent $event): void
    {
        foreach (User::whereNot('id', $event->comment->user_id)->cursor() as $user) {
            $user->notify(new NewCommentNotification($event->comment));
        }
    }
}
