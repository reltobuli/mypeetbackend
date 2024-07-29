<?php 

namespace App\Notifications;

use App\Models\Pet;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdoptionRequestRejected extends Notification
{
    use Queueable;

    protected $pet;

    public function __construct(Pet $pet)
    {
        $this->pet = $pet;
    }

    public function via($notifiable)
    {
        return ['database']; 
    }

    public function toDatabase($notifiable)
    {
        return [
            'pet_id' => $this->pet->id,
            'pet_name' => $this->pet->name,
            'message' => 'Your adoption request for ' . $this->pet->name . ' has been rejected.',
        ];
    }
}