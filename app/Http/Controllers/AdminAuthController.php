<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin_login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin-web')->attempt($credentials, $request->filled('remember'))) {
            return redirect()->intended(route('admin.index'));
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    public function logout() {
        Auth::user()->tokens()->delete();
        return response([
            'message' => 'User tokens deleted successfully',
        ], 200);
    }
}
