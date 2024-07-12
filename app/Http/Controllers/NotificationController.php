<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class NotificationController extends Controller
{
   
    public function Notifications()
    {
        try {
            $user = Auth::user();
            $notifications = $user->notifications; // Assuming you have a notifications relationship on the user model

            Log::info('Notifications fetched successfully', ['notifications' => $notifications]);

            return response()->json(['notifications' => $notifications], 200);
        } catch (\Exception $e) {
            Log::error('Failed to fetch notifications', ['error' => $e->getMessage()]);

            return response()->json(['error' => 'Failed to fetch notifications'], 500);
        }
    }
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications;
        return response()->json($notifications);
        return response()->json(['notifications' => $notifications], 200);
    }
}

