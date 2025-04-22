<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ActivationNotification extends Notification
{
    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $activationUrl = url('http://localhost:3000/account/activate?token=' . $this->token);

        return (new MailMessage)
            ->subject('Activez votre compte RiadBookingNow')
            ->view('emails.activation', [
                'activationUrl' => $activationUrl
            ]);
    }
}
