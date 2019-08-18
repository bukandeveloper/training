<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
      switch ($guard) {
        case 'admin':
          if (Auth::guard($guard)->check()) {
            if(Auth::guard($guard)->user()->is_super){
              return redirect()->route('admin');
            }else{
              return redirect()->route('admin.members');
            }
          }
          break;
        default:
          if (Auth::guard($guard)->check()) {
              return redirect('/member');
          }
          break;
      }
        return $next($request);
    }
}
