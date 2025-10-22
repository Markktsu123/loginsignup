<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SignLanguageController extends Controller
{
    public function sign(Request $request)
    {
        // Ensure user is authenticated
        if (!$request->user()) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        $pageTitle = "Sign Language";
        
        return view('sign-language', compact('pageTitle'));
    }
}   