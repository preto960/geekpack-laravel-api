<?php

namespace Geekpack\Api\Listeners;

use Geekpack\Api\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Geekpack\Api\Notifications\VerifyEmailNotification;

class SendEmailVerificationNotification
{
    public function handle(Registered $event)
    {
        $event->user->notify(new VerifyEmailNotification());
    }
}
