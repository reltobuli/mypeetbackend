<?php

namespace App\Http\Controllers;

use App\Models\Shelter; // Ensure the Shelter model is correctly imported
use Illuminate\Http\Request;

class ShelterController extends Controller
{
    public function index()
    {
        $shelters = Shelter::all();
        return response()->json($shelters);
    }
}