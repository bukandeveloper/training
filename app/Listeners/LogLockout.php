<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\AdminLoginHistory;
use App\Models\MembersLoginHistory;
use App\Models\User;
use App\Models\Admin;
use Mail;
use Carbon\Carbon;

class LogLockout
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
     * @param  Lockout  $event
     * @return void
     */
    public function handle(Lockout $event)
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
       if($guard == 'admin'){
            $user = Admin::where('email', $event->request->email)->first();
       }else{
            $user = User::where('email', $event->request->email)->first();
       }

       $userExist = $user ? true : false;

       if($guard == 'admin'){
            $log = new AdminLoginHistory;
            if($userExist){
                $log->email = $user->email;
            }else{
                $log->not_exist_user = $event->request['email'];
            }
            $log->failed_login_at = date('Y-m-d H:i:s');
            $log->ip_address = request()->ip();
            $log->save();
       }else{
            $log = new MembersLoginHistory;
            if($userExist){
                $log->email = $user->email;
                $log->user_id = $user->id;
            }else{
                $log->not_exist_user = $event->request['email'];
            }
            $log->failed_login_at = date('Y-m-d H:i:s');
            $log->ip_address = request()->ip();
            $log->save();
       }

        // Check how many Login Attempts was made and send Email
        $this->sendEmailNotifications($event->request->email, $userExist, $user, $guard);
    }


    /**
     * Handle the email For Lockout Event.
     *
     * @param  Lockout  $event
     * @param  $username resquested username
     * @param  $isExist  is users is exist in database or not
     * Eg. admin received email on Monday due to failed login attempt by a user.
     * When that user keeps trying on Monday and fail, no further email to admin.
     * However when the date changes, to Tuesday and user tries again and fail, admin will receive an email.
     * @return void
     */
    protected function sendEmailNotifications($email, $isExist, $user, $guard){
        $maxAttempts = \Config::get('const.MAXIMUM_NUMBER_OF_ATTEMPTS');
        /** check how many attempt was saved, if equal $maxAttempts + 1
        * then send an Email to admin, but if more than $maxAttempts then don't
        * Eg. admin received email on Monday due to failed login attempt by a user.
        * When that user keeps trying on Monday and fail, no further email to admin.
        * However when the date changes, to Tuesday and user tries again and fail, admin will receive an email.
        */
        if($isExist){
            // Check how many login attempts was made today for registered users
            // Carbon::today() for checking today's attempt
            if($guard == 'admin'){
                $numberOfAttemptSaved = AdminLoginHistory::where('email', $user->email)
                ->where('ip_address', request()->ip())
                ->whereDate('failed_login_at', Carbon::today())->count();
            }else{
                $numberOfAttemptSaved = MembersLoginHistory::where('user_id', $user->id)
                ->where('ip_address', request()->ip())
                ->whereDate('failed_login_at', Carbon::today())->count();
            }

        }else{
            // Check how many login attempts was made today for non registered users
            // Carbon::today() for checking today's attempt
            if($guard == 'admin'){
                $numberOfAttemptSaved = AdminLoginHistory::where('not_exist_user', $email)
                ->where('ip_address', request()->ip())
                ->whereDate('failed_login_at', Carbon::today())->count();
            }else{
                $numberOfAttemptSaved = MembersLoginHistory::where('not_exist_user', $email)
                ->where('ip_address', request()->ip())
                ->whereDate('failed_login_at', Carbon::today())->count();
            }

        }

        // Check if user login attempt has been reach the limit
        // send email to admin if only attempt was x times = max login attempts + 1
        // this is for only send email to admin one times
        // if the user tries to login again and fails just save to database on above functions.
        if($numberOfAttemptSaved == ($maxAttempts + 1)){
            $content = ($isExist) ? \Config::get('const.LOGIN_EMAIL_CONTENT_ATTEMPT') : \Config::get('const.LOGIN_EMAIL_CONTENT_USER_NOT_EXIST');
            $title = ($isExist) ? \Config::get('const.LOGIN_ATTEMPTS_EMAIL_TITLE') : \Config::get('const.LOGIN_EMAIL_TITLE_USER_NOT_EXIST');
            $guardLabel = $guard == 'user' ? 'ユーザー' : '管理者';
            $data = [
                'content'=>$content,
                'title'=>$title,
                'user_id'=>$isExist,
                'email'=>$email,
                'guard'=>$guardLabel,
                'ip_address'=>request()->ip(),
                'numberOfLoginAttempts'=>$numberOfAttemptSaved,
                'periodOfTime'=>Carbon::now()
            ];
            Mail::send('mail.send_mail_login_attempts', $data, function($message) use ($data) {
                $to = \Config::get('const.ADMIN_EMAIL');
                foreach($to as $adminEmail){
                    $message->to($adminEmail);
                }
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                  ->subject($data['title']);
              });
        }
    }
}
