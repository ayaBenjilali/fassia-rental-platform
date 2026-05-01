<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdStatusChanged extends Notification
{
    use Queueable;

    protected $message;
    protected $adId;
    protected $type;
    protected $redirectUrl;

    public function __construct($message, $adId, $type = 'info', $redirectUrl = null)
    {
        $this->message = $message;
        $this->adId = $adId;
        $this->type = $type;
        $this->redirectUrl = $redirectUrl;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
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

        return $data;
    }
}
