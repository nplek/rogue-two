<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct() {
        $this->middleware('permission:view-department',['only' => 'index']);
    }

    public function index(Request $request){
        $token = $request->session()->get('tokens');
        return view('departments.index',compact('token'));
    }
}
