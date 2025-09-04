<?php

namespace App\Http\Controllers;

class SignLanguageController extends Controller
{
    public function sign()
    {
        $pageTitle = "Sign Language";
        
        return view('sign-language');
    }
}   