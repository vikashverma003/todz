<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    
    public function __construct(){
        
    }
    
    public function getProfilePage(Request $request){
        $currentUser = $user=Auth::guard('admin')->user();
        $title='Profile Details';

        return view('admin.profile.index', compact('user','currentUser','title'));
    }
}
