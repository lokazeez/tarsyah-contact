<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('lang')) {
            $lang = Session::get('lang');
        } else if (request('lang')) {
            $lang = request('lang');
        } else {
            $lang = 'ar';
        }
        if(in_array($request->header('Accept-Language'),config('app.locales'))) {
            // Check header request and determine localization
            $lang = ($request->hasHeader('Accept-Language')) ? $request->header('Accept-Language') : $lang;
        }

        // set laravel localization
        app()->setLocale($lang);
        Config::set('translatable.locale', $lang);
        Session::put('lang', $lang);

        return $next($request);
    }
}
