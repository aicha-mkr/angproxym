<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecapSentNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Votre récapitulatif hebdomadaire a été envoyé avec succès.')
                    ->action('Voir le Récapitulatif', url('/'))
                    ->line('Merci d\'utiliser notre application !');
    }
}
