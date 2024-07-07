<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use Illuminate\Support\Facades\Validator;

class PetController extends Controller
{
    /**
     * Display the authenticated pet owner's profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $pet = Pet::findOrFail($id);
        return response()->json($pet);
    }
    public function profile()
    {
        $user = auth('Petowner-api')->user();
        return response()->json(['user' => $user]);
    }

    /**
     * Update the authenticated pet owner's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $user = auth('Petowner-api')->user();

        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:male,female',
            'email' => 'required|string|email|max:255',
            'city' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        $user->update($request->all());

        return response()->json(['message' => 'Profile updated successfully', 'user' => $user]);
    }

    /**
     * Show the edit form for the authenticated pet owner's profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit()
    {
        $user = auth('Petowner-api')->user();
        return response()->json(['user' => $user]);
    }

    /**
     * Update the authenticated pet owner's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
   

    /**
     * Show the edit form for the authenticated pet owner's profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
  
     public function addPet(Request $request)
     {
         // Validate the incoming request data
         $validatedData = $request->validate([
            'user_id'=>'required|string|max:255',
             'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
             'name' => 'required|string|max:255',
             'type' => 'required|string|max:255',
             'gender' => 'required|string|max:255',
             'age' => 'required|integer',
             'color' => 'required|string|max:255',
             'address'=>'required|string|max:255',
          
         
         ]);
     
         // Handle the picture upload if it's included in the request
         if ($request->hasFile('picture')) {
             $picturePath = $request->file('picture')->store('pictures', 'public');
             $validatedData['picture'] = $picturePath;
         }
     
         // Create a new pet record in the database
         $pet = Pet::create($validatedData);
     
         // Return a JSON response with the newly created pet data
         return response()->json($pet, 201);
     }
    /**
     * Add a pet for the authenticated pet owner.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
   

    // You can add more methods here for other actions related to pet owners
}
