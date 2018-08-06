<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function __construct() {
        $this->middleware('permission:view-team',['only' => 'index']);
    }

    public function index(Request $request)
    {
        $token = $request->session()->get('tokens');
        return view('teams.index',compact('token'));
    }
}
