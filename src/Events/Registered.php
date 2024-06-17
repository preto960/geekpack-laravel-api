<?php

namespace Geekpack\Api\Listeners;

use Geekpack\Api\Events\Registered;
use Geekpack\Api\Notifications\VerifyEmailNotification;
use Illuminate\Support\Facades\Log;

class SendEmailVerificationNotification
{
    public function handle(Registered $event)
    {
        $user = $event->user;

        // Log that the notification is being sent
        Log::info("Sending email verification to user: {$user->email}");

        $user->notify(new VerifyEmailNotification());
    }
}
