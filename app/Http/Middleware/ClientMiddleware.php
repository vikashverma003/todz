<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class ClientMiddleware
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
        $loginedInUser=Auth::user();
        if($loginedInUser->role!=config('constants.role.CLIENT')){
            if($loginedInUser->role==config('constants.role.TALENT')){
            return redirect()->route('talent_dashboard');
        }else{
            return redirect()->route('home');
        }
        }
        return $next($request);
    }
}
