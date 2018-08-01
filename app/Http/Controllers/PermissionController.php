<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(Request $request){
        $token = $request->session()->get('tokens');
        return view('permissions.index',compact('token'));
    }
}
