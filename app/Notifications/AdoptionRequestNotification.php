<?php 

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdoptionRequestNotification extends Notification
{
    use Queueable;

    protected $pet;
    protected $requester;

    public function __construct($pet, $requester)
    {
        $this->pet = $pet;
        $this->requester = $requester;
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
            'requester_id' => $this->requester->id,
            'requester_name' => $this->requester->name,
            'requester_email' => $this->requester->email,
            'message' => 'You have received a new adoption request for your pet ' . $this->pet->name,
        ];
    }
    public function acceptRequest($id)
    {
        $pet = Pet::findOrFail($id);
        $pet->adoption_status = Pet::ADOPTION_ADOPTED;
        $pet->save();

        return response()->json(['message' => 'Adoption request accepted.']);
    }

    public function rejectRequest($id)
    {
        $pet = Pet::findOrFail($id);
        $pet->adoption_status = Pet::ADOPTION_AVAILABLE;
        $pet->save();

        return response()->json(['message' => 'Adoption request rejected.']);
    }
    // You can define other notification channels here (e.g., database, Slack, etc.)
}
