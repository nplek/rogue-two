<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;

class LogSuccessfullLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        
        $user = $event->user;
        $user->last_login_at = date('Y-m-d H:i:s');
        $user->last_login_ip = $this->request->ip();
        $user->disableLogging();
        $user->save();

        activity('auth')
        ->causedBy($user)
        ->withProperties([
            'ip' => $this->request->ip(), 
            'method' => $this->request->method(),
            'agent'  => $this->request->header('user-agent'),
            'user_id' => auth()->check() ? auth()->user()->id : 1,
            'url' => $this->request->fullUrl()
        ])
        ->log('log in success');
    }
}