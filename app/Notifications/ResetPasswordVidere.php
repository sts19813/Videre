<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordVidere extends ResetPassword
{
    public function toMail($notifiable)
    {
        $resetUrl = url(route(
            'password.reset',
            [
                'token' => $this->token,
                'email' => $notifiable->email,
            ],
            false
        ));

        return (new MailMessage)
            ->subject('Restablecer contraseña – Videre')
            ->view('emails.reset-password-videre', [
                'user' => $notifiable,
                'resetUrl' => $resetUrl,
                'expire' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire'),
            ]);
    }
}
