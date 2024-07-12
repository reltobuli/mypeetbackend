<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet; // Add this line
use App\Models\Petowner;
use App\Models\AdoptionRequest;
use App\Notifications\RequestStatusNotification;

use App\Notifications\AdoptionRequestAccepted;
use App\Notifications\AdoptionRequestRejected;

class AdoptionController extends Controller
{
    public function accept($adoptionRequestId)
    {
        $adoptionRequest = AdoptionRequest::findOrFail($adoptionRequestId);

        // Update the pet status to 'unavailable'
        $pet = Pet::find($adoptionRequest->pet_id);
        $pet->adoption_status = 'unavailable';
        $pet->save();

        // Update the adoption request status to 'accepted'
        $adoptionRequest->status = 'accepted';
        $adoptionRequest->save();

        // Notify the user who made the request
        $user = Petowner::find($adoptionRequest->user_id);
        $user->notify(new RequestStatusNotification($adoptionRequest, 'accepted'));

        return response()->json(['message' => 'Adoption request accepted successfully']);
    }

    public function reject($adoptionRequestId)
    {
        $adoptionRequest = AdoptionRequest::findOrFail($adoptionRequestId);

        // Update the adoption request status to 'rejected'
        $adoptionRequest->status = 'rejected';
        $adoptionRequest->save();

        // Notify the user who made the request
        $user = Petowner::find($adoptionRequest->user_id);
        $user->notify(new RequestStatusNotification($adoptionRequest, 'rejected'));

        return response()->json(['message' => 'Adoption request rejected successfully']);
    }
}
