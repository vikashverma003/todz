<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class TestStatusCheck
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
        if($loginedInUser->role!=config('constants.role.TALENT')){
            if($loginedInUser->role==config('constants.role.CLIENT')){
                return redirect()->route('client_dashboard');
            }else{
                return redirect()->route('home');
            }
        }
        // elseif(
        //     $loginedInUser->talent->is_profile_screened ==config('constants.test_status.APPROVED') && 
        //     $loginedInUser->talent->is_aptitude_test ==config('constants.test_status.APPROVED') &&
        //     $loginedInUser->talent->is_technical_test ==config('constants.test_status.APPROVED') &&
        //     $loginedInUser->talent->is_interview ==config('constants.test_status.APPROVED')){
        //         return redirect()->route('talent_dashboard');
        //    }
        return $next($request);
    }
}
