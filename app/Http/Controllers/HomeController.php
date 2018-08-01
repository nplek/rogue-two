<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\Permission as PermissionResource;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user() == null){
            return redirect("/login");
        }
        $permissions = Auth::user()->allPermissions();
        $token = $request->session()->get('tokens');
        return view('home',compact('token','permissions'));
    }
}
