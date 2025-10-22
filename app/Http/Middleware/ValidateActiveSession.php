<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ValidateActiveSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('session-expired', 'Your session has expired. Please log in again.');
        }

        // Check if user is active
        $user = Auth::user();
        if (!$user || $user->status !== 'active') {
            Auth::logout();
            Session::invalidate();
            Session::regenerateToken();
            return redirect()->route('login')->with('account-inactive', 'Your account is inactive. Please contact support.');
        }

        // For AJAX requests, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'authenticated' => true,
                'user' => [
                    'id' => $user->userid,
                    'name' => $user->fullName,
                    'email' => $user->email,
                    'status' => $user->status
                ],
                'session_valid' => true,
                'timestamp' => now()->timestamp
            ]);
        }

        // Add session validation data to the view
        $request->attributes->set('session_valid', true);
        $request->attributes->set('user_data', [
            'id' => $user->userid,
            'name' => $user->fullName,
            'email' => $user->email,
            'status' => $user->status,
            'last_activity' => now()->timestamp
        ]);

        return $next($request);
    }
}

