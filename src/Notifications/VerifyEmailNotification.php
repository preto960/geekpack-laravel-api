<?php

namespace Geekpack\Api\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;

class VerifyEmailNotification extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $verificationUrl = url('/api/email/verify/'.$notifiable->id.'/'.sha1($notifiable->email));

        Log::info('Preparing to send email verification', [
            'to' => $notifiable->email,
            'verificationUrl' => $verificationUrl,
        ]);

        return (new MailMessage)
            ->subject('Verify Email Address')
            ->line('Please click the button below to verify your email address.')
            ->action('Verify Email Address', $verificationUrl)
            ->line('If you did not create an account, no further action is required.');
    }

    public function toLog($notifiable)
    {
        $verificationUrl = url('/api/email/verify/'.$notifiable->id.'/'.sha1($notifiable->email));

        Log::info('Logging email verification details', [
            'to' => $notifiable->email,
            'verificationUrl' => $verificationUrl,
        ]);
    }
}
