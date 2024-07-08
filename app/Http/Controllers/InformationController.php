<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shelter;
use App\Models\Veterinarycenter;
use App\Models\Instruction;

class InformationController extends Controller
{
    public function showInstructions()
    {
        $instructions = Instruction::all();
        return response()->json($instructions);
    }

    public function listShelters()
    {
        $shelters = Shelter::all();
        return response()->json($shelters);
    }

    public function listVeterinaries()
    {
        $veterinaries = VeterinaryCenter::all(); // Ensure the model name matches your actual model
        return response()->json($veterinaries);
    }
}
