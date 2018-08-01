<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request){
        $token = $request->session()->get('tokens');
        return view('locations.index',compact('token'));
    }
}
