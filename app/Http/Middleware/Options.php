<?php

namespace App\Http\Middleware;

use App\Models\Common\Settings;
use Illuminate\Http\Request;
use Cookie;
use Closure;

class Options {

    function getUserIP() {
        if( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')>0) {
                $addr = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
                return trim($addr[0]);
            } else {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }
        else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    public function handle($request, Closure $next, $guard = null)
    {

      //  abort( 403,$request->path());
        $undeconstruction = false;

        $MyIP = '78.96.92.27';

        if ($undeconstruction){
        $ip = $request->ip();
        if ($request->path() != "InConstructie")
            if (!in_array($ip, [$MyIP])) {
                return redirect('/InConstructie');
                
            }
        }

        $locale =  $request->cookie('lang-symbol');

        if (Cookie::has('lang-symbol')) {
            $locale = Cookie::get('lang-symbol');

        }
        else {
         
            $locale = 'RO';
           
        }

        session(['Locale' => $locale]);


        app()->setLocale($locale);

        return $next($request);
    }
}
