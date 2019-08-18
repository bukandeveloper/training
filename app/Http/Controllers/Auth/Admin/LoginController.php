<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\AdminLoginHistory;

class LoginController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users (in this case admins) for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

    use AuthenticatesUsers;

    protected $maxAttempts;
    protected $decayMinutes;

    /**
     * Where to redirect admin after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        // Put 'guest' middleware during controller creation except for logput
        $this->middleware('guest:admin')->except('logout');
        $this->maxAttempts = \Config::get('const.MAXIMUM_NUMBER_OF_ATTEMPTS');
        $this->decayMinutes = \Config::get('const.NUMBER_OF_MINUTES_TO_THROTTLE');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Shows the login form
     *
     * @return void
     */
    public function showLoginForm() {
        return view('auth.admin.login');
    }

    /**
     * Returns authentication guard of admin
     */
    protected function guard() {
        return Auth::guard('admin');
    }

    /**
     * Logs out admin from system and wipes session
     *
     * @return void
     */
    public function logout(Request $request) {

        // change is_online to 0, mean user is not online
        $saveOnline = Admin::find(Auth::guard('admin')->id());
        $saveOnline->is_online = 0;
        $saveOnline->save();

        // Use specific guard to log out
        Auth::guard('admin')->logout();

        // Invalidates the current session.
        // Clears all session attributes and flashes and regenerates the session and deletes the old session from persistence.
        $request->session()->invalidate();

        // Redirect back to admin login
        return redirect('/admin/login');
    }

    /**
     * Overrides default function authenticated in AuthenticatedUsers.php
     * Set up redirect for home page when user is detected as authenticated via successful login
     * This has higher precedence than redirectTo(), so if this is used, no need to use $redirectTo or redirectTo()
     */
    protected function authenticated(Request $request) {

        // change is_online to 1, mean user is online
        $saveOnline = Admin::find(Auth::guard('admin')->id());
        $saveOnline->is_online = 1;
        $saveOnline->save();

        // Save login history
        $this->saveLoginHistory();
        // Redirect to line-user list by default
        if(Auth::guard('admin')->user()->is_super){
            return redirect('/admin');
        }else{
            return redirect('/admin/members');
        }
    }

    /**
     * Save login history for admin
     * @return void
     */
    protected function saveLoginHistory() {
        $loginHistory = new AdminLoginHistory;
        // Use global function request() to get IP
        $loginHistory->ip_address = request()->ip();
        $loginHistory->email = Auth::guard('admin')->user()->email;
        $loginHistory->login_at = date('Y-m-d H:i:s');
        $loginHistory->save();
    }

}
