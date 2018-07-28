<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct() {
        //$this->middleware('role:super|admin',['only' => 'index']);
    }

    public function index()
    {
        return view('companies.index');
    }
}
