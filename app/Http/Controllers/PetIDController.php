<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use Illuminate\Support\Facades\Auth;

class PetIDController extends Controller
{
    /**
     * Constructor to apply middleware for authentication.
     */
    public function __construct()
    {
        $this->middleware('auth:Petowner-api'); // Requires authentication for API requests
    }

    /**
     * Fetch the pet_id for the current authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchPetId()
    {
        // Retrieve the authenticated user's ID
        $userId = Auth::id();

        // Query the Pet model to find the pet owned by the user
        $pet = Pet::where('user_id', $userId)->first();

        if ($pet) {
            return response()->json(['pet_id' => $pet->id], 200);
        } else {
            return response()->json(['message' => 'Pet not found for this user'], 404);
        }
    }
}

