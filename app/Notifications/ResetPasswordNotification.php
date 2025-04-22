<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
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
        // URL de réinitialisation du mot de passe
        $activationUrl = url("http://localhost:3000/reset-password?token={$this->token}&email={$notifiable->email}");

        return (new MailMessage)
            ->subject('Réinitialisation de votre mot de passe RiadBookingNow')
            ->view('emails.resetPassword', [
                'activationUrl' => $activationUrl
            ]);
    }
}
