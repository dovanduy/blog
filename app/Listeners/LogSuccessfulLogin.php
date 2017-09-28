<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Http\Request;
use App\IP;
use Auth;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        //
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        //
        $addressIp = $this->request->ip();
        $user = $event->user;
        $user->ip = $addressIp;
        $user->save();
        $ip = new IP();
        $ip->user_id = Auth::id();
        $ip->ip = $addressIp;
        $ip->save();
    }
}
