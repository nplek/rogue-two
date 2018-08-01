<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;

class LogLastLogout
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
        $this->request->session()->flush();
        
        $user = $event->user;
        $user->last_logout_at = date('Y-m-d H:i:s');
        $user->disableLogging();
        $user->save();
        //$user->token()->revoked();

        activity('auth')
        ->causedBy($user)
        ->withProperties([
            'ip' => $this->request->ip(), 
            'method' => $this->request->method(),
            'agent'  => $this->request->header('user-agent'),
            'user_id' => auth()->check() ? auth()->user()->id : 1,
            'url' => $this->request->fullUrl()
        ])
        ->log('log out success');
    }
}
