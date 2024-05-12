<?php

namespace App\Notifications\Auth;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Costruisci la mail da inviare.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
                ->subject('Reimposta la password')
                ->from('hopelast532@gmail.com', 'no-reply')
                ->view(
                    'auth.reset-password-mail',
                    [
                        'user_name' => $notifiable->name,
                        'url' => $url
                    ]
                );
    }
}