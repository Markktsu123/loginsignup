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
            // Clear any cached data
            $this->clearCachedData($request);
            
            return redirect()->route('login')->with('session-expired', 'Your session has expired. Please log in again.');
        }

        // Check if user is active
        $user = Auth::user();
        if (!$user || $user->status !== 'active') {
            // Log security event
            \Log::warning('Inactive user attempted access', [
                'user_id' => $user->userid ?? 'unknown',
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
                'timestamp' => now()
            ]);
            
            Auth::logout();
            Session::invalidate();
            Session::regenerateToken();
            
            // Clear any cached data
            $this->clearCachedData($request);
            
            return redirect()->route('login')->with('account-inactive', 'Your account is inactive. Please contact support.');
        }

        // Update last activity timestamp
        $this->updateLastActivity($user);

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

    /**
     * Clear cached data to prevent unauthorized access
     */
    private function clearCachedData(Request $request): void
    {
        // Clear any application cache
        if (function_exists('cache')) {
            cache()->forget('user_' . Auth::id());
        }

        // Clear session data
        Session::flush();
    }

    /**
     * Update user's last activity timestamp
     */
    private function updateLastActivity($user): void
    {
        // Update last activity in session
        Session::put('last_activity', now()->timestamp);
        
        // You can also update the database if you have a last_activity column
        // $user->update(['last_activity' => now()]);
    }
}

