<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        // Debug: Log the incoming request data
        \Log::info('Password update request data:', [
            'password_exists' => $request->has('password'),
            'password_length' => strlen($request->input('password', '')),
            'password_confirmation_exists' => $request->has('password_confirmation'),
            'password_confirmation_length' => strlen($request->input('password_confirmation', '')),
            'all_input_keys' => array_keys($request->all()),
            'request_method' => $request->method(),
            'request_url' => $request->url(),
            'user_id' => $user->id,
            'user_email' => $user->email
        ]);

        try {
            $validated = $request->validateWithBag('updatePassword', [
                'current_password' => ['required', 'current_password'],
                'password' => [
                    'required', 
                    'confirmed',
                    'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{}|;:"\'<>,.?\/])[A-Za-z\d!@#$%^&*()_+\-=\[\]{}|;:"\'<>,.?\/]{8,}$/'
                ],
            ], [
                'current_password.required' => 'Current password is required.',
                'current_password.current_password' => 'The current password is incorrect.',
                'password.required' => 'New password is required.',
                'password.confirmed' => 'Password confirmation does not match.',
                'password.min' => 'Password must be at least 8 characters.',
                'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character',
            ]);

            // Hash the new password before saving
            $newPasswordHash = Hash::make($validated['password']);
            
            \Log::info('Password update successful:', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'new_password_hash' => $newPasswordHash
            ]);

            // Update the user's password
            $user->update([
                'password' => $newPasswordHash,
            ]);

            // Log the user out immediately after password change
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('password-changed', 'Password updated successfully! Please log in with your new password.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Password validation failed:', $e->errors());
            return back()->withErrors($e->errors(), 'updatePassword');
        } catch (\Exception $e) {
            \Log::error('Password update exception:', ['message' => $e->getMessage()]);
            return back()->withErrors(['password' => 'An unexpected error occurred. Please try again.'], 'updatePassword');
        }
    }
}
