<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\Pet;
use App\Models\Petowner;
use App\Models\AdoptionRequest;
use App\Notifications\AdoptionRequestNotification;
use Illuminate\Support\Facades\Notification;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::all();
        return response()->json(['pets' => $pets]);
    }

    public function getPets()
    {
        $pets = Pet::all(); // Example logic to fetch pets
        return response()->json(['pets' => $pets]);
    }


    public function show($id)
    {
        $pet = Pet::find($id);

        if ($pet) {
            return response()->json($pet, 200);
        } else {
            return response()->json(['message' => 'Pet not found'], 404);
        }
    }

    public function getPetsForCurrentUser()
    {
        try {
            $user = Auth::guard('Petowner-api')->user(); // Retrieve authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $pets = $user->pets; // Fetch pets associated with the user

            return response()->json(['pets' => $pets], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching pets for current user: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching pets'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Validate request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|string|max:255',
                'gender' => 'required|string|max:255',
                'age' => 'required|integer',
                'color' => 'required|string|max:255',
                'address' => 'required|string|max:255',
            ]);

            // Find the pet
            $pet = Pet::find($id);

            if (!$pet) {
                return response()->json(['error' => 'Pet not found'], 404);
            }

            // Update pet details
            $pet->name = $validatedData['name'];
            $pet->type = $validatedData['type'];
            $pet->gender = $validatedData['gender'];
            $pet->age = $validatedData['age'];
            $pet->color = $validatedData['color'];
            $pet->address = $validatedData['address'];
            $pet->save();

            return response()->json(['message' => 'Pet profile updated successfully', 'pet' => $pet], 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update pet profile'], 500);
        }
    }

    public function edit()
    {
        $user = auth('Petowner-api')->user();
        return response()->json(['user' => $user]);
    }

    public function addPet(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'age' => 'required|integer',
            'color' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('pictures', 'public');
            $validatedData['picture'] = $picturePath;
        }

        $pet = Pet::create($validatedData);

        return response()->json($pet, 201);
    }

    public function giveUpPet($id)
    {
        try {
            $pet = Pet::findOrFail($id);
            $pet->adoption_status = Pet::ADOPTION_AVAILABLE;
            $pet->save();

            return response()->json(['message' => 'Pet is now available for adoption.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update pet adoption status'], 500);
        }
    }

    public function getAdoptablePets()
    {
        try {
            $adoptablePets = Pet::where('adoption_status', Pet::ADOPTION_AVAILABLE)->get();

            if ($adoptablePets->isEmpty()) {
                return response()->json(['message' => 'No adoptable pets found'], 404);
            }

            return response()->json(['pets' => $adoptablePets], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch adoptable pets'], 500);
        }
    }

    // Request adoption for a specific pet
    public function requestAdoption(Request $request, $id)
{
    $userID = Auth::id(); // The ID of the authenticated Petowner
    $petId = $id;

    // Validate the request data
    $request->validate([
        'message' => 'required|string|max:255',
    ]);

    // Create a new adoption request
    $adoptionRequest = AdoptionRequest::create([
        'user_id' => $userID,
        'pet_id' => $petId,
        'message' => $request->input('message'),
    ]);

    // Find the pet owner (Petowner) associated with the pet
    $petowner = Pet::find($petId)->owner;

    // Notify the pet owner about the adoption request
    Log::info('Sending notification to pet owner', ['petowner_id' => $petowner->id, 'adoption_request_id' => $adoptionRequest->id]);

    $petowner->notify(new AdoptionRequestNotification($adoptionRequest));

    return response()->json(['message' => 'Adoption request sent successfully', 'adoptionRequest' => $adoptionRequest], 201);
}
}


