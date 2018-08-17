<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemGroupController extends Controller
{
    public function __construct() {
        $this->middleware('permission:view-item',['only' => 'index']);
    }

    public function index(Request $request){
        $token = $request->session()->get('tokens');
        return view('itemgroups.index',compact('token'));
    }
}
