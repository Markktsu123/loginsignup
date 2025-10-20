<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Ramsey\Uuid\Uuid;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'fullName' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/', 'min:2'],
            'email'    => [
                'required', 
                'string', 
                'lowercase', 
                'email', 
                'max:255', 
                'unique:users,email',
                'regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|outlook\.com|yahoo\.com)$/'
            ],
            'password' => [
                'required', 
                'confirmed',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#^()_\-+=\[\]{}|\\:;"\'<>,.\/])[A-Za-z\d@$!%*?&#^()_\-+=\[\]{}|\\:;"\'<>,.\/]{8,}$/'
            ],
        ], [
            'fullName.regex' => 'Name should only contain letters and spaces',
            'email.regex' => 'Email must be from gmail.com, outlook.com, or yahoo.com',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character',
        ]);

        // 🚀 UUID is auto-generated in User::boot(), so we don’t touch it here
        $user = User::create([
            'fullName' => $request->fullName,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',   // default role
            'status'   => 'active', // default status
        ]);

        event(new Registered($user));

        // Redirect to login page with success message
        return redirect()->route('login')->with('success', 'Account created successfully! Please log in to continue.');
    }
}
