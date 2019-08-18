<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\AdminLoginHistory;
use App\Models\MembersLoginHistory;

class LogFailedLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Failed  $event
     * @return void
     */
    public function handle(Failed $event)
    {
       // Laravel can't give use Guard session for determine which guard is being
       // used for this request in Listener, we have to parse it from login path
       $path = app('request')->getPathInfo();
       if($path == '/login'){
            $guard = 'user';
       }elseif($path == '/admin/login'){
            $guard = 'admin';
       }


       // Check if users is exist in database
       $userExist = $event->user ? true : false;

       if($guard == 'admin'){
            $log = new AdminLoginHistory;
            if($userExist){
                $log->email = $event->user['email'];
            }else{
                $log->not_exist_user = $event->credentials['email'];
            }
            $log->failed_login_at = date('Y-m-d H:i:s');
            $log->ip_address = request()->ip();
            $log->save();
       }else{
            $log = new MembersLoginHistory;
            if($userExist){
                $log->email = $event->user['email'];
                $log->user_id = $event->user['id'];
            }else{
                $log->not_exist_user = $event->credentials['email'];
            }
            $log->failed_login_at = date('Y-m-d H:i:s');
            $log->ip_address = request()->ip();
            $log->save();
       }
    }
}
