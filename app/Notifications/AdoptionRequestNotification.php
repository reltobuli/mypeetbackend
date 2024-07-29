<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdoptionRequestNotification extends Notification
{
    protected $adoptionRequest;

    public function __construct($adoptionRequest)
    {
        $this->adoptionRequest = $adoptionRequest;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'adoption_request_id' => $this->adoptionRequest->id,
            'pet_name' => $this->adoptionRequest->pet->name,
            'message' => $this->adoptionRequest->message,
            'adopter_id' => $this->adoptionRequest->user_id,
        ];
    }
}