<?php

namespace Geekpack\Api\Listeners;

use Geekpack\Api\Events\Registered;
use Geekpack\Api\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendEmailVerificationNotification implements ShouldQueue
{
    public function handle(Registered $event)
    {
        $user = $event->user;

        Log::info("Sending email verification to user: {$user->email}");

        $user->notify(new VerifyEmailNotification());
    }
}
