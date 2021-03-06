<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User; 
use Auth; 

class LoginController extends Controller
{
    public $successStatus = 200;

    public function login(Request $request){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('rogue-api')->accessToken;
            return response()->json(['success' => $success], $this->successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    public function destroy(Request $request)
    {
        $request->user()->token()->revoke();

        return new Response('', 204);
    }
}
