<?php

namespace App\Http\Middleware;
use Auth;

use Closure;

class AdminCheck
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

        if(Auth::check() && Auth::user()->user_type == 'admin'){
            return $next($request);
        }else{
            return redirect()->back();
        }

        return $next($request);
    }
}
