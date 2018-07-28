<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogController extends Controller
{
    public function activityLogIndex()
    {
        return view('logs.activityLog');
    }

    public function accessLogIndex()
    {
        return view('logs.accessLog');
    }

    public function securityLogIndex()
    {
        return view('logs.securityLog');
    }
}
