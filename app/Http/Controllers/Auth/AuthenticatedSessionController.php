<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Log the logout for security tracking
        \Log::info('User logout', [
            'user_id' => Auth::id(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()
        ]);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Clear any cached data
        $this->clearUserCache($request);

        // For AJAX requests, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'logged_out' => true,
                'redirect' => route('login'),
                'message' => 'Logged out successfully'
            ]);
        }

        return redirect()->route('login');
    }

    /**
     * Clear user-related cache and data
     */
    private function clearUserCache(Request $request): void
    {
        // Clear any application cache related to the user
        if (function_exists('cache')) {
            cache()->forget('user_' . Auth::id());
        }

        // Clear any session-related cache
        $request->session()->flush();
    }
}
