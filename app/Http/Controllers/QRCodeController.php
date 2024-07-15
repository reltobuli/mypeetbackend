<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Pet;

class QRCodeController extends Controller
{
    public function show($id)
    {
        // Fetch pet data by ID, handle case if pet is not found
        try {
            $pet = Pet::with('owner')->findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Pet not found'], 404);
        }
    
        // Check if the pet has an owner
        if (!$pet->owner) {
            return response()->json(['message' => 'Owner not found for this pet'], 404);
        }
    
        // Create a URL with pet information
        $url = json_encode([
            'name' => $pet->name,
            'type' => $pet->type,
            'owner' => $pet->owner->name,
            'contact' => $pet->owner->email, // Assuming the contact is the owner's email
        ]);
    
        // Generate QR code
        $qrCode = QrCode::size(300)->generate($url);
    
        // Return QR code as response
        return response($qrCode)->header('Content-Type', 'image/svg+xml');
    }
    
}








