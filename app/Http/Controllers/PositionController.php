<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function __construct() {
        $this->middleware('permission:view-position',['only' => 'index']);
    }

    public function index(Request $request){
        $token = $request->session()->get('tokens');
        return view('positions.index',compact('token'));
    }
}
