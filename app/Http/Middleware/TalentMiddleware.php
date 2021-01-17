<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class TalentMiddleware
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
        if($loginedInUser->role!=config('constants.role.TALENT'))
        {
            if($loginedInUser->role==config('constants.role.CLIENT')){
                return redirect()->route('client_dashboard');
            }else{
                return redirect()->route('home');
            }
        }elseif($loginedInUser->registration_step!=3){
            return redirect()->route('signup_work');
        }elseif(
            $loginedInUser->talent->is_profile_screened !=config('constants.test_status.APPROVED') || 
            $loginedInUser->talent->is_aptitude_test !=config('constants.test_status.APPROVED') ||
            $loginedInUser->talent->is_technical_test !=config('constants.test_status.APPROVED') ||
            $loginedInUser->talent->is_interview !=config('constants.test_status.APPROVED'))
        {
            if(url()->full()== route('talent_profile')){
        		return $next($request);
        	}
            return redirect()->route('test_status.index');
        }
        return $next($request);
    }
}
