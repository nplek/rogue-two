<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware('permission:view-role',['only' => 'index']);
    }

    public function index(Request $request){
        $token = $request->session()->get('tokens');
        return view('roles.index',compact('token'));
    }
}
