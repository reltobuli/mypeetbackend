<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdoptionRequestAccepted extends Notification
{
    use Queueable;

    protected $adoptionRequest;

    public function __construct($adoptionRequest)
    {
        $this->adoptionRequest = $adoptionRequest;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Your adoption request has been accepted.')
                    ->action('View Request', url('/adoption-requests/'.$this->adoptionRequest->id))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'id' => $this->adoptionRequest->id,
            'pet_name' => $this->adoptionRequest->pet->name,
            'message' => 'Your adoption request has been accepted.'
        ];
    }
}
