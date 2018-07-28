<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function page400()
    {
        return view('errors.400');
    }
    
    public function page403()
    {
        return view('errors.403');
    }
}
