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

    public function __construct($message, $adId, $type = 'info')
    {
        $this->message = $message;
        $this->adId = $adId;
        $this->type = $type;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->message,
            'ad_id' => $this->adId,
            'type' => $this->type,
        ];
    }
}
