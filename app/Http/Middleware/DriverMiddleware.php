<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class DriverMiddleware
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
        if(Auth::check() && Auth::user()->role != 2 && Auth::user()->role == 1)
        {
            return redirect('/user');
        }
        else if(Auth::check() && Auth::user()->role != 2 && Auth::user()->role == 3)
        {
            return redirect('/admin');
        }
        return $next($request);
    }
}
