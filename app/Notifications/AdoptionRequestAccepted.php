<?php

namespace App\Notifications;

use App\Models\AdoptionRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdoptionRequestAccepted extends Notification
{
    use Queueable;

    public function acceptAdoptionRequest($adoptionRequestId)
{
    $adoptionRequest = AdoptionRequest::findOrFail($adoptionRequestId);
    // Perform logic to accept the adoption request

    // Notify the pet owner that their adoption request has been accepted
    $adoptionRequest->petowner->notify(new AdoptionRequestAccepted($adoptionRequest));

    return response()->json(['message' => 'Adoption request accepted']);
}
    protected $adoptionRequest;

    public function __construct(AdoptionRequest $adoptionRequest)
    {
        $this->adoptionRequest = $adoptionRequest;
    }

    public function via($notifiable)
    {
        return ['database']; // You can add other channels like 'mail', 'slack', etc.
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Your adoption request has been accepted.',
            'adoption_request_id' => $this->adoptionRequest->id,
            // Add any other data you want to include in the notification
        ];
    }
}