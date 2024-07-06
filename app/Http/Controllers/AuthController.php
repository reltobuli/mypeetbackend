<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Correct import for Request
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Petowner;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender'=>'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:petowners',
            'city' => 'required|string|max:255',
            'password' => 'required|string|min:8|',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $petowner = Petowner::create([
            'fullname' => $request->fullname,
            'phone_number' => $request->phone_number,
            'date_of_birth' => $request->date_of_birth,
            'gender'=>$request->gender,
            'email' => $request->email,
            'city' => $request->city,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Pet owner registered successfully', 'petowner' => $petowner], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('Petowner')->attempt($credentials)) {
            $petowner = Auth::guard('Petowner')->user();
            $token = $petowner->createToken('auth_token')->plainTextToken;

            return response()->json(['message' => 'Login successful', 'token' => $token], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        Auth::guard('Petowner')->user()->tokens()->delete();

        return response()->json(['message' => 'Logout successful'], 200);
    }
}