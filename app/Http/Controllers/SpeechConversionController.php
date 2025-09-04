<?php

namespace App\Http\Controllers;

class SpeechConversionController extends Controller
{
    public function index()
    {
        $pageTitle = "Speech Conversion";
        
        return view('speech-conversion');
    }
}   