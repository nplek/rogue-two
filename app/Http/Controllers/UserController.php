<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request){
        $token = $request->session()->get('tokens');
        return view('users.index',compact('token'));
    }

    public function employee(){
        return view('employees.index');
    }
}
