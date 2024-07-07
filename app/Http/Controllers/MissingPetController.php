<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\MissingPet;

class MissingPetController extends Controller
{

    public function index()
    {
        $missingPets = MissingPet::all();
        return response()->json(['missingPets' => $missingPets]);
    }
    public function reportMissingPet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'age' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'qrcode' => 'required|string|max:255',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pet_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', ['errors' => $validator->errors()]);
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $imageName = null;
            if ($request->hasFile('picture')) {
                $image = $request->file('picture');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/missing-pet-images', $imageName);
            }

            $missingPet = new MissingPet();
            $missingPet->name = $request->name;
            $missingPet->type = $request->type;
            $missingPet->gender = $request->gender;
            $missingPet->age = $request->age;
            $missingPet->color = $request->color;
            $missingPet->address = $request->address;
            $missingPet->qrcode = $request->qrcode;
            $missingPet->pet_id = $request->pet_id;
            $missingPet->picture = $imageName;
            $missingPet->save();

            return response()->json(['message' => 'Missing pet reported successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Exception caught', ['exception' => $e->getMessage()]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function fetchMissingPets()
    {
        try {
            $missingPets = MissingPet::all();

            $formattedPets = $missingPets->map(function ($pet) {
                return [
                    'picture' => $pet->picture,
                    'name' => (string) $pet->name,
                    'type' => (string) $pet->type,
                    'gender' => (string) $pet->gender,
                    'age' => (string) $pet->age,
                    'color' => (string) $pet->color,
                    'address' => (string) $pet->address,
                    'qrcode' => (string) $pet->qrcode,
                    'pet_id' => (string) $pet->pet_id,
                ];
            });

            return response()->json(['missingPets' => $formattedPets], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching missing pets:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
