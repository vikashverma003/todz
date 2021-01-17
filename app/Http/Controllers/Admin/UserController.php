<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Admin;
use Illuminate\Support\Facades\Hash;
use App\Rules\IsAdminCurrentPassword;
use App\Mail\AdminPasswordChangeMail;

class UserController extends Controller
{
    /**
     * return Login page
     */
    public function index(){
        if (Auth::guard('admin')->check()) {
            return redirect('admin/dashboard');
        }
       Auth::guard('admin')->logout();
        return view('admin.login', ['title' => 'Login Page']);
    }

    /**
     * Check admin user Detail
     */
    public function login(Request $request){

        $request->validate([
          'email' => 'required|email|exists:admins,email',
          'password' => 'required|min:6',
        ]);
        if (!Auth::guard('admin')->check()) {
            $email=$request->get('email');
            $password=$request->get('password');
            $account_status = Admin::where('email', $email)->value('account_status');
            if($account_status==0){
                return redirect('admin/login')->with('error', 'Your account is disabled. Please try to contact Admin.');
            }
            
            if (Auth::guard('admin')->attempt(['email' => $email, 'password' => $password, 'account_status'=>config('constants.account_status.ACTIVE')])) {
                return redirect('admin/dashboard');
            }else{
                return redirect('admin/login')->with('error', 'Login credential is not valid ');
            }
        }else{
            return redirect('admin/dashboard');
        }
    }
    
    // logout method
    public function logout(){
      Auth::guard('admin')->logout();
        return redirect('admin/login');
        // return redirect(\URL::previous());
    }

    public function getChangePassword(Request $request){
        $title= 'Change Password';
        $user = Auth::user();
        return view('admin.profile.change-password', compact('title','user'));
    }

    public function updateChangePassword(Request $request){
        $email = isset(Auth::guard('admin')->user()->email) ? Auth::guard('admin')->user()->email: '';

         $request->validate([
            'current_password'=>['bail','required','string','min:6',new IsAdminCurrentPassword($email)],
            'password'=>'bail|required|string|min:6|max:25',
            'confirm_password'=>'bail|required|string|min:6|max:25|same:password',
        ]);

        $authId = isset(Auth::guard('admin')->user()->id) ? Auth::guard('admin')->user()->id: '';
        Admin::where('id', $authId)->update(['password'=>Hash::make($request->password)]);
        \Mail::to($email)->send(new AdminPasswordChangeMail);

        Auth::guard('admin')->logout();
        return response()->json(['status'=>true,'message'=>'Password changed successfully.','url'=>url('admin/login')], 200);
        return redirect('admin/login');
    }
}
