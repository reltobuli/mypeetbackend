<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RequestStatusNotification extends Notification
{
    protected $adoptionRequest;
    protected $status;

    public function __construct($adoptionRequest, $status)
    {
        $this->adoptionRequest = $adoptionRequest;
        $this->status = $status;
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
            'message' => 'Your adoption request has been ' . $this->status,
            'status' => $this->status,
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'adoption_request_id' => $this->adoptionRequest->id,
            'pet_name' => $this->adoptionRequest->pet->name,
            'message' => 'Your adoption request has been ' . $this->status,
            'status' => $this->status,
        ];
    }
}