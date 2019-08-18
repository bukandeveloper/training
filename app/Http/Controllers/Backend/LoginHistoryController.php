<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminLoginHistory;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Member;

class LoginHistoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        // Get User / Admin Auth
        $this->middleware(function ($request, $next) {
            // Update Admin Last Access when Access Backend Page
            if(Auth::guard('admin')->check()) {
                Admin::where('id', Auth::guard('admin')->id())
                    ->update(['last_access' => \DB::raw('now()')]); 
            }
            // Update User Last Access when Access Backend Page
            if(Auth::guard('member')->check()) {
                Member::where('id', Auth::guard('member')->id())
                    ->update(['last_access' => \DB::raw('now()')]);
            }

            return $next($request);
        });
    }
    
    /**
     * Get named route depends on which user is logged in
     *
     */
    private function getRoute() {
        return Auth::guard('admin')->check() ? 'admin' : 'user';
    }

	/**
	* Display a listing of the resource. For admin.
	*
	* @return \Illuminate\Http\Response
	*/
	public function LoginHistoriesAdmin() {
		return view('backend.login_histories.admin', [
            'route' => $this->getRoute()
        ]);
	}

	/**
	* Display a listing of the resource. for user.
	*
	* @return \Illuminate\Http\Response
	*/
	  public function LoginHistoriesUser() {
	      return view('backend.login_histories.user', [
            'route' => $this->getRoute()
        ]);
	  }
}
