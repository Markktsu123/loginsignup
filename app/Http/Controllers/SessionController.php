<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    /**
     * Validate the current session
     */
    public function validateSession(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'authenticated' => false,
                'session_valid' => false,
                'message' => 'User not authenticated',
                'redirect' => route('login'),
                'timestamp' => now()->timestamp
            ], 401);
        }

        // Check if user is active
        $user = Auth::user();
        if (!$user || $user->status !== 'active') {
            // Logout the user if inactive
            Auth::logout();
            Session::invalidate();
            Session::regenerateToken();
            
            return response()->json([
                'authenticated' => false,
                'session_valid' => false,
                'message' => 'User account is inactive',
                'redirect' => route('login'),
                'timestamp' => now()->timestamp
            ], 401);
        }

        // Session is valid
        return response()->json([
            'authenticated' => true,
            'session_valid' => true,
            'user' => [
                'id' => $user->userid,
                'name' => $user->fullName,
                'email' => $user->email,
                'status' => $user->status
            ],
            'timestamp' => now()->timestamp
        ]);
    }

    /**
     * Force logout and clear session
     */
    public function forceLogout(Request $request)
    {
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();

        if ($request->ajax()) {
            return response()->json([
                'logged_out' => true,
                'redirect' => route('login'),
                'message' => 'Session terminated'
            ]);
        }

        return redirect()->route('login')->with('session-terminated', 'Your session has been terminated for security reasons.');
    }
}

