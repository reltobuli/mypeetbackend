<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstructionController extends Controller
{
    public function index()
    {
        // Your logic here
        return response()->json(['instructions' => 'List of instructions']);
    }}
