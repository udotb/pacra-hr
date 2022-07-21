<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class BeforeLoginUrlChecker
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

        if(!empty(session()->get('userData'))){
            //dd('eeeee');
            return redirect()->action('HomeController@index');
        }

        return $next($request);
    }
}
