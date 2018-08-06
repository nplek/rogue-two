<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __construct() {
        $this->middleware('permission:view-location',['only' => 'index']);
    }

    public function index(Request $request){
        $token = $request->session()->get('tokens');
        return view('locations.index',compact('token'));
    }
}
