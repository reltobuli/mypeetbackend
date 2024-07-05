<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdoptionRequest;
use App\Models\Pet;
use Illuminate\Support\Facades\Auth;

class AdoptionController extends Controller
{
    public function index()
    {
        $pets = Pet::where('is_up_for_adoption', true)->get();
        return response()->json($pets);
    }

    public function requestAdoption(Request $request, $id)
    {
        $pet = Pet::findOrFail($id);

        $adoptionRequest = AdoptionRequest::create([
            'user_id' => Auth::id(),
            'pet_id' => $pet->id,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Adoption request sent', 'request' => $adoptionRequest]);
    }

    public function approveAdoption(Request $request, $id)
    {
        $adoptionRequest = AdoptionRequest::findOrFail($id);

        $this->authorize('update', $adoptionRequest->pet);

        $adoptionRequest->update(['status' => 'approved']);

        // Transfer pet ownership logic
        $adoptionRequest->pet->update(['user_id' => $adoptionRequest->user_id, 'is_up_for_adoption' => false]);

        return response()->json(['message' => 'Adoption request approved']);
    }

    public function rejectAdoption(Request $request, $id)
    {
        $adoptionRequest = AdoptionRequest::findOrFail($id);

        $this->authorize('update', $adoptionRequest->pet);

        $adoptionRequest->update(['status' => 'rejected']);

        return response()->json(['message' => 'Adoption request rejected']);
    }
}
