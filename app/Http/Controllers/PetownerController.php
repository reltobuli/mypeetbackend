<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Petowner;
use App\Models\Pet;
use Illuminate\Support\Facades\Hash; // Add this line

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PetownerController extends Controller
{
    public function profile()
    {
        $user = auth('Petowner-api')->user();
    return response()->json(['user' => $user]);
    }

    public function updateProfile(Request $request)
{
    try {
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'city' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
        ]);

        $user = auth()->user(); // Assuming you're using the default auth guard

        $user->fullname = $validatedData['fullname'];
        $user->phone_number = $validatedData['phone_number'];
        $user->date_of_birth = $validatedData['date_of_birth'];
        $user->gender = $validatedData['gender'];
        $user->email = $validatedData['email'];
        $user->city = $validatedData['city'];

        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return response()->json(['message' => 'Profile updated successfully'], 200);
    } catch (ValidationException $e) {
        // Handle validation errors
        return response()->json(['error' => $e->errors()], 422);
    } catch (\Exception $e) {
        // Log the exception
        \Log::error('Profile update error: ' . $e->getMessage());

        // Handle general errors
        return response()->json(['error' => 'An error occurred while updating profile'], 500);
    }
}
    // Other methods...



    public function AddPet(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'age' => 'required|integer',
            'color' => 'required|string|max:255',
            'address'=>'required|string|max:255',
           
        ]);

        $pet = new Pet();
        $pet->picture = 'default.jpg';
        $pet->name = $validatedData['name'];
        $pet->type = $validatedData['type'];
        $pet->age = $validatedData['age'];
        $pet->gender = $validatedData['gender'];
        $pet->age = $validatedData['age'];
        $pet->color = $validatedData['color'];
        $pet->address = $validatedData['address'];
      
        $pet->save();

        $validatedData['petowner_id'] = auth('Petowner-api')->id();
        // Handle the picture upload if included in request
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('pictures', 'public');
            $validatedData['picture'] = $picturePath;
        }
        // Create a new pet record in the database
        $pet = Pet::create($validatedData);
        // Return a JSON response with the newly created pet data
        return response()->json($pet, 201);
    }
    public function edit()
    {
        $user = auth('Petowner-api')->user();
        return response()->json(['user' => $user]);
    }

    // Additional methods here
}
