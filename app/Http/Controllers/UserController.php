<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('permission:view-user',['only' => 'index']);
        $this->middleware('permission:view-employee',['only' => 'employee']);
    }

    public function index(Request $request){
        $token = $request->session()->get('tokens');
        return view('users.index',compact('token'));
    }

    public function employee(Request $request){
        $token = $request->session()->get('tokens');
        return view('employees.index',compact('token'));
    }
}
