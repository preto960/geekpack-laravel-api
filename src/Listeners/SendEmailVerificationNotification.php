<?php

namespace Geekpack\Api\Listeners;

use Geekpack\Api\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Geekpack\Api\Notifications\VerifyEmailNotification;

class SendEmailVerificationNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  \Geekpack\Api\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        // Log the email verification information
        Log::info('Sending email verification to user', [
            'user_id' => $event->user->id,
            'email' => $event->user->email,
            'name' => $event->user->name,
        ]);

        // Send the email verification notification
        $event->user->notify(new VerifyEmailNotification());
    }
}
