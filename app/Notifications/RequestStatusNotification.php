<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class RequestStatusNotification extends Notification
{
    use Queueable;

    protected $adoptionRequest;
    protected $status;

    public function __construct($adoptionRequest, $status)
    {
        $this->adoptionRequest = $adoptionRequest;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database']; // or ['mail', 'database'] if using multiple channels
    }

    public function toArray($notifiable)
    {
        return [
            'adoption_request_id' => $this->adoptionRequest->id,
            'pet_name' => $this->adoptionRequest->pet->name, // assuming the pet has a name attribute
            'message' => "Your adoption request has been {$this->status}.",
        ];
    }
}
