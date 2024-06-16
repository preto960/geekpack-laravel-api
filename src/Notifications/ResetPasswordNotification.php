<?php

namespace Geekpack\Api\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    // Define the delivery channels for the notification
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = $this->resetUrl($notifiable);

        return (new MailMessage)
            ->subject('Reset Password Notification')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', $url)
            ->line('If you did not request a password reset, no further action is required.');
    }

    protected function resetUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'api.password.update', // Make sure this route is defined in your API routes file
            Carbon::now()->addMinutes(60),
            ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()]
        );
    }
}
