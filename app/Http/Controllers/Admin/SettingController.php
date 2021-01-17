<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    use \App\Traits\MangoPayManager;
    public function __construct(){
        
    }
    
    public function getPaymentDetailsPage(Request $request){
        $currentUser = $user=Auth::guard('admin')->user();
        $title='Payment Details';
        $kycDoc=$bankAccounts=$walletInfo=null;
        if(!is_null($currentUser->mangopayUser)){
            $token=$this->token();
            if(!$token){
                return redirect('admin/dashboard')->with(['error'=>'The token not created.']);
            }
            $bankAccounts=$this->listBankAccount($token->access_token,$currentUser->mangopayUser->mangopay_user_id);
            $walletInfo=$this->veiwWallet($token->access_token,$currentUser->mangopayUser->mangopay_wallet_id);
            $kycDoc=$this->listKycDoc($token->access_token,$currentUser->mangopayUser->mangopay_user_id);
        }

        return view('admin.settings.payment-details', compact('user','currentUser','title','kycDoc','bankAccounts','walletInfo'));
    }
}
