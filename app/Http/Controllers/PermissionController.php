<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct() {
        $this->middleware('permission:view-permission',['only' => 'index']);
    }

    public function index(Request $request){
        $token = $request->session()->get('tokens');
        return view('permissions.index',compact('token'));
    }
}
