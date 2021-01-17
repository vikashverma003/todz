<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class LoggedUserMiddleWare
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
        if(Auth::guard('admin')->check()){
            return $next($request);
        }
        elseif (Auth::check()) {
            return $next($request);
        }
        else{
            return redirect('/');
        }
    }
}
