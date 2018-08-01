<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct() {
        //$this->middleware('role:super|admin',['only' => 'index']);
    }

    public function index(Request $request)
    {
        $token = $request->session()->get('tokens');
        return view('companies.index',compact('token'));
    }
}
