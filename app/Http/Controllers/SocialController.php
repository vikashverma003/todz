<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Log;
use Redirect,Session;

class SocialController extends Controller
{
    //


    public function fb_redirect(Request $request)
    {
        $type = $request->type ?? '0';

        Session::put('submit_type',$type);

        return \Socialite::driver('facebook')->stateless()->redirect();
    }
    public function fb_callback(Request $request)
    {   
       
        $type = Session::get('submit_type','0');
        if (!$request->has('code') || $request->has('denied')) {
            return redirect('/');
        }
        $userSocial =   \Socialite::driver('facebook')->stateless()->user();
        $user = $userSocial->user;
        $user['provider']  = 'facebook';
        if($type == '1')
        {
            return redirect::route('signup.index')->with(['data'=>$user]);
        }
        return Redirect::route('social_web')->with( ['data' => $user] );   
    }

    public function li_redirect(Request $request)
    {
        $type = $request->type??'0';
        Session::put('submit_type',$type);
        return \Socialite::driver('linkedin')->stateless()->redirect();
    }
    public function li_callback(Request $request)
    {
        $type = Session::get('submit_type','0');
        if (!$request->has('code') || $request->has('denied')) {
            return redirect('/');
        }
        $userSocial =   \Socialite::driver('linkedin')->stateless()->user();
        $user = $userSocial->user;
       // echo $user;die();
        $user['provider']  = 'linkedin';
        if($type == '1')
        {
            return redirect::route('signup.index')->with(['data'=>$user]);
        }
        return Redirect::route('social_web')->with( ['data' => $user] );   
    }
}
