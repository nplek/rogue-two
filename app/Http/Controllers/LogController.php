<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogController extends Controller
{
    public function __construct() {
        $this->middleware('permission:view-activitylog',['only' => 'activityLogIndex']);
        $this->middleware('permission:view-accesslog',['only' => 'accessLogIndex']);
        $this->middleware('permission:view-securitylog',['only' => 'securityLogIndex']);
    }

    public function activityLogIndex(Request $request)
    {
        $token = $request->session()->get('tokens');
        return view('logs.activityLog',compact('token'));
    }

    public function accessLogIndex(Request $request)
    {
        $token = $request->session()->get('tokens');
        return view('logs.accessLog',compact('token'));
    }

    public function securityLogIndex(Request $request)
    {
            $token = $request->session()->get('tokens');
            return view('logs.securityLog',compact('token'));
    }
}
