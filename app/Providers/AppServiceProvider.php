<?php

namespace App\Providers;

// per customizzare la mail di verifica
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
// docs: https://laravel.com/docs/11.x/notifications#mail-notifications
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verifica mail')
                ->from('hopelast532@gmail.com', 'no-reply')
                ->view(
                    'auth.mail-verification-mail',
                    [
                        'user_name' => $notifiable->name,
                        'url' => $url
                    ]
                );
        });

        // VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
        //     return (new MailMessage)
        //         ->greeting('Salve ' . $notifiable->name . ',')
        //         ->subject('Verifica indirizzo Email')
        //         ->line('verifica la tua mail')
        //         ->action('Verifica indirizzo Email', $url);
        // });
    }


}
