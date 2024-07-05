<?php

namespace App\Http\Controllers;

use App\Models\MissingPet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MissingPetController extends Controller
{
    public function reportMissingPet(Request $request)
    {
       
        Log::info('reportMissingPet method called');
        Log::info('Request data:', $request->all());

        try {
            $request->validate([
                'name' => 'required|string',
                'type' => 'required|string',
                'gender' => 'required|string',
                'age' => 'required|string',
                'color' => 'required|string',
                'address' => 'required|string',
                'qrcode' => 'required|string',
                'picture' => 'required|image',
                
            ]);

            // Store the uploaded image in the 'public/pictures' directory
            $picturePath = $request->file('picture')->store('pictures', 'public');

            // Create a new MissingPet record
            $missingPet = MissingPet::create([
                'name' => $request->name,
                'type' => $request->type,
                'gender' => $request->gender,
                'age' => $request->age,
                'color' => $request->color,
                'address' => $request->address,
                'qrcode' => $request->qrcode,
                'picture' => $picturePath,
            ]);

            Log::info('Pet reported successfully');
            return response()->json(['message' => 'Pet reported successfully']);
        } catch (\Exception $e) {
            Log::error('Error reporting pet:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
