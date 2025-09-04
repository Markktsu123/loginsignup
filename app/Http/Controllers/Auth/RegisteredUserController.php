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
            'fullName' => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
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

        // Auto login after registration
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Welcome aboard, ' . $user->fullName . ' 🎉');
    }
}
