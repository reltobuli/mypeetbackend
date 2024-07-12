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

    // Example controller method to fetch notifications
public function notifications()
{
    $user = auth('Petowner-api')->user();
        return response()->json($user->notifications);
}
    public function pets()
    {
        return $this->hasMany(Pet::class);
    }
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
        // Validate request
        $request->validate([
            'user_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'age' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Handle the file upload
        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $path = $file->store('public/pictures');
            $fileName = basename($path);
        } else {
            return response()->json(['message' => 'Picture not uploaded'], 400);
        }
    
        // Create new pet record
        $pet = new Pet();
        $pet->user_id = $request->input('user_id');
        $pet->name = $request->input('name');
        $pet->type = $request->input('type');
        $pet->gender = $request->input('gender');
        $pet->age = $request->input('age');
        $pet->color = $request->input('color');
        $pet->address = $request->input('address');
        $pet->picture = $fileName;
        $pet->save();
    
        return response()->json(['message' => 'Pet added successfully'], 201);
    }
    public function edit()
    {
        $user = auth('Petowner-api')->user();
        return response()->json(['user' => $user]);
    }

    // Additional methods here
}
