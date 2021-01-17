<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminMiddleWare
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
        if($loginedInUser->role!=config('constants.role.ADMIN')){
            if($loginedInUser->role==config('constants.role.CLIENT')){
                return redirect()->route('client_dashboard');
            }else{
                return redirect()->route('talent_dashboard');
            }
        }
        return $next($request);
    }
}
