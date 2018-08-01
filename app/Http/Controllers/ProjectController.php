<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request){
        $token = $request->session()->get('tokens');
        return view('projects.index',compact('token'));
    }
}
