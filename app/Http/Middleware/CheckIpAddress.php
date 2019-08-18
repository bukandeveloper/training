<?php

namespace App\Http\Middleware;

use Closure;
use Config;

class CheckIpAddress
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
        // Get Client Ip Address
        $clientIP = $request->getClientIp();
        $whitelist = array(
            '127.0.0.1',
            '::1'
        );

        $allowFromCountry = Config::get('const.IP_ENABLE_FORM_ACCESS');
        //Turn Of Country Based Access if $allowFromCountry is False
        if($allowFromCountry && is_array($allowFromCountry)){
          // Check if App Is Access From Localhost Or Local Development
          // Remove $location->country_code2 != 'ID' if not Needed, it just for testing
          // Puposes
          if(!in_array($clientIP, $whitelist)){
              // Find Geolocation from Client IP Address
              // And Find Country Code
              $location = geoip($clientIP);
              if(!in_array($location->country_code2, $allowFromCountry)) {
                 // Check it the request come from estimate form
                 // only estimate form has a plan_id then we can make sure that
                 // request from estimate form and redirect the request to
                 // estimate thanks page
                 if($request->has('plan_id')){
                      return redirect('estimate-thanks');
                 }else{
                     // just redirect the request to contact-thanks page
                      return redirect('contact-thanks');
                 }
              }
          }  
        }

        return $next($request);

    }
}
