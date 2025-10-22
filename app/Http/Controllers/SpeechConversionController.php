<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpeechConversionController extends Controller
{
    public function index(Request $request)
    {
        // Ensure user is authenticated
        if (!$request->user()) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        $pageTitle = "Speech Conversion";
        
        return view('speech-conversion', compact('pageTitle'));
    }
}   