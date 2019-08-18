<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
//    protected $redirectTo = '/home';

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
     * Redirect to reset success page then logs in to system
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function redirectTo() {
        Auth::logout();
        Session::flash('success', 'パスワードが変更されました。');
        return 'reset-success';
    }

    /**
     * Show form for admin to reset password
     */
    public function showResetForm(Request $request, $token = null) {
        return view('auth.passwords.reset')->with(
                ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Display reset password success page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resetSuccess() {
        return view('auth.passwords.reset-success');
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
