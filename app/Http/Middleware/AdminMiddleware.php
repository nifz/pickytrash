<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
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
        if(Auth::check() && Auth::user()->role != 3 && Auth::user()->role == 2)
        {
            return redirect('/driver');
        }
        else if(Auth::check() && Auth::user()->role != 3 && Auth::user()->role == 1)
        {
            return redirect('/user');
        }
        return $next($request);
    }
}
