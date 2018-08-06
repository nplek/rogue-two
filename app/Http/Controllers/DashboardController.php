<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $token = $request->session()->get('tokens');
        return view('dashboard',compact('token'));
    }
}
