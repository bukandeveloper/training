<?php

namespace App\Http\Middleware;

use Closure;
use Config;

class RedirectIfNotWhitelistedIPs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        // Catch Next request to get route and middleware access
        $req = $next($request);
        // check if that route need to auth or login page
        $needAuth = isset($request->route()->computedMiddleware)?$request->route()->computedMiddleware:[];
        $auth = array_map(function($v){
            if(!is_object($v)){
                return $v;
            }
        }, $needAuth);
        $filter   =  Config::get('const.WHITELISTED_ROUTE_FILTER'); 
        $result = array_intersect($filter, $auth);  
        if(sizeof($result) > 0){
            foreach ($request->getClientIps() as $ip) {
                // check ip address if not in the list just sbort the request
                // otherwise just return next request
                if (! $this->isValidIp($ip)) {
                    # Show 404 page
                    abort(404);
                    
                    # uncomment this line if want to redirect to top page 
                    # return redirect('/');
                }
            }
        }
        return $req;
        
    }

    /** Check if requested ip in the allowed list */
    protected function isValidIp($ip)
    {
        $allowedIP = $to = Config::get('const.WHITELISTED_IP'); 
        if(!$allowedIP){
            return true;
        }else{
            return in_array($ip, $allowedIP);
        }
        
    }
}