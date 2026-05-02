<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use Illuminate\Notifications\Messages\MailMessage;

class AdStatusChanged extends Notification
{
    use Queueable;

    protected $message;
    protected $adId;
    protected $type;
    protected $redirectUrl;
    protected $senderId;

    public function __construct($message, $adId, $type = 'info', $redirectUrl = null, $senderId = null)
    {
        $this->message = $message;
        $this->adId = $adId;
        $this->type = $type;
        $this->redirectUrl = $redirectUrl;
        $this->senderId = $senderId;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = $this->redirectUrl ?? url('/dashboard');
        
        $sujet = "Mise à jour de votre réservation sur L'Fassia";
        if ($this->type === 'success') {
            $sujet = "Confirmation de votre location - L'Fassia 🎉";
        }

        return (new MailMessage)
            ->subject($sujet)
            ->greeting('Bonjour ' . ($notifiable->prenom ?? $notifiable->name ?? ''))
            ->line("Nous vous contactons pour vous informer d'une mise à jour concernant votre activité sur notre plateforme de location de tenues traditionnelles.")
            ->line("**Message :** " . $this->message)
            ->action("Consulter mon compte", $url)
            ->line("Si vous avez des questions, n'hésitez pas à répondre à cet email ou à nous contacter via notre service de messagerie interne.")
            ->line("Merci de faire confiance à L'Fassia pour vos événements !")
            ->salutation("Cordialement, \nL'Équipe L'Fassia");
    }

    public function toArray(object $notifiable): array
    {
        $data = [
            'message' => $this->message,
            'ad_id' => $this->adId,
            'type' => $this->type,
        ];

        if ($this->redirectUrl) {
            $data['redirect_url'] = $this->redirectUrl;
        }

        if ($this->senderId) {
            $data['sender_id'] = $this->senderId;
        }

        return $data;
    }
}
