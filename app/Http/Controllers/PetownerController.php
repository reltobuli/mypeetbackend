<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Petowner;
use App\Models\Pet;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PetownerController extends Controller
{
    public function profile()
    {
        $user = auth('Petowner-api')->user();
    return response()->json(['user' => $user]);
    }

    public function update(Request $request)
    {
        try {
            $user = auth('Petowner-api')->user();
    
            $request->validate([
                'fullname' => 'required|string|max:255',
                'phone_number' => 'required|string|max:20',
                'date_of_birth' => 'required|date',
                'gender' => 'required|string|in:male,female',
                'email' => 'required|string|email|max:255',
                'city' => 'required|string|max:255',
                'password' => 'nullable|string|max:255',
            ]);
    
            // Log the received request data for debugging
            \Log::info('Request data:', $request->all());
    
            // Update user details
            $user->fullname = $request->input('fullname');
            $user->phone_number = $request->input('phone_number');
            $user->date_of_birth = $request->input('date_of_birth');
            $user->gender = $request->input('gender');
            $user->email = $request->input('email');
            $user->city = $request->input('city');
    
            if ($request->has('password')) {
                $user->password = bcrypt($request->input('password'));
            }
    
            $user->save();
    
            // Log the updated user data for debugging
            \Log::info('Updated user data:', $user);
    
            return response()->json(['message' => 'Profile updated successfully', 'user' => $user]);
        } catch (\Exception $e) {
            // Log any exceptions for debugging
            \Log::error('Exception caught: ' . $e->getMessage());
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
