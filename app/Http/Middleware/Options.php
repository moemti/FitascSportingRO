<?php

namespace App\Http\Middleware;

use App\Models\Common\Settings;
use Cookie;
use Closure;

class Options {



    public function handle($request, Closure $next, $guard = null)
    {


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
