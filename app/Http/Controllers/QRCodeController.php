<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    public function generate(Request $request)
    {
        $data = $request->input('data', 'Default QR Code Data'); // Get data from request or use default

        // Generate the QR code image
        $qrCode = QrCode::size(300)->generate($data);

        // Return the QR code as an image
        return response($qrCode)->header('Content-Type', 'image/svg+xml');
    }
}

