<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
     // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    /**
     * Show form for admin to reset password
     */
    public function showResetForm(Request $request, $token = null) {
        return view('auth.admin.reset')->with(
                ['token' => $token, 'email' => $request->email]
        );
    }
    
    /**
     * Override the default to get admin broker to be used during password reset.
     * 'admin' refers to the value defined in auth.php 'passwords'
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker() {
        return Password::broker('admins');
    }
    
    /**
     * Returns authentication guard of admin
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
    
    /**
     * Redirect to reset success page then logs in to system
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function redirectTo() {
        Auth::logout();
        Session::flash('success', 'パスワードが変更されました。');
        return 'admin/reset-success';
        
    }

    /**
     * Display reset password success page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resetSuccess() {
        return view('auth.admin.reset-success');
    }
    
    /**
     * Override the default function
     * Reset the given user's password, but don't automatically login just yet
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->setRememberToken(Str::random(60));

        $user->save();
        event(new PasswordReset($user));
    }

}
