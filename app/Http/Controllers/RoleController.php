<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request){
        $token = $request->session()->get('tokens');
        return view('roles.index',compact('token'));
    }

    public function passport(){

        $client = Auth::user()->client();
        return view('vendor.passport.authorize',compact('client'));
    }
}
