<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'pet_name' => 'required|string|max:255',
        ]);

        $petName = $request->input('pet_name');
        $qrCode = QrCode::format('png')->size(300)->generate($petName);

        return response($qrCode)->header('Content-type', 'image/png');
    }
}















