<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\TalentRepositoryInterface;
use App\Repositories\Interfaces\SkillRepositoryInterface;
use Validator,Hash,Auth;
use App\Repositories\Interfaces\SavedUserCardRepositoryInterface;
use App\Repositories\Interfaces\AppsCountryRepositoryInterface;

class ProfileController extends Controller
{
    use \App\Traits\MangoPayManager;
    private $user;
    private $appsCountry;
    public function __construct(UserRepositoryInterface $user,TalentRepositoryInterface $talent,SkillRepositoryInterface $skill,SavedUserCardRepositoryInterface $saveUserCard,AppsCountryRepositoryInterface $appsCountry){
        $this->user=$user;
        $this->talent=$talent;
        $this->skill=$skill;
        $this->saveUserCard=$saveUserCard;
        $this->appsCountry=$appsCountry;
    }


    public function index(Request $request){
        $currentUser=$this->user->getCurrentUser();
        $Cards=null;
        $walletInfo=null;
       $bankAccounts=null;
       $kycDoc=null;
        if(!is_null($currentUser->mangopayUser)){
       
            $token=$this->token();
            if(!$token){
                return redirect(route('siteError', ['message'=>'Token not generated. Please try again later.']));
            }
            $bankAccounts=$this->listBankAccount($token->access_token,$currentUser->mangopayUser->mangopay_user_id);
        //  dd( $bankAccounts);
            //  dd($token->access_token,$currentUser->mangopayUser->mangopay_user_id,$currentUser->mangopayUser->mangopay_wallet_id,25,$currentUser->mangopayCard[0]->card_id);
         // dd($this->payInFromDirectCard($token->access_token,$currentUser->mangopayUser->mangopay_user_id,$currentUser->mangopayUser->mangopay_wallet_id,25,$currentUser->mangopayCard[0]->card_id));
            //dd($this->preauthrizePayment($token->access_token,'79697259',50,'79763005'));
           // dd($this->createPreAuthorizedPayIn($token->access_token,'79697259','79705001','79705002','79846341'));
            $walletInfo=$this->veiwWallet($token->access_token,$currentUser->mangopayUser->mangopay_wallet_id);
              //  dd(  $walletInfo);  
            //  dd($token,$currentUser->mangopayUser->mangopay_user_id);
          $Cards=$this->listAllUserCards( $token->access_token,$currentUser->mangopayUser->mangopay_user_id);
          $kycDoc=$this->listKycDoc($token->access_token,$currentUser->mangopayUser->mangopay_user_id);
          $array_docx = json_decode(json_encode($kycDoc), true);
          if(is_array($array_docx))
          {
          $count_docx=count($array_docx);
        }

        }
        $defaultCardid=$this->saveUserCard->getDefaultCardId($currentUser->id);
     //   dd( $defaultCardid);
        return view('web.client.profile.index',compact('currentUser','count_docx','Cards','walletInfo','defaultCardid','bankAccounts','kycDoc'));
    }

    public function updateProfile(Request $request){
        $currentUser=$this->user->getCurrentUser();
        $errors =[
            'first_name'=>'required',
            'last_name'=>'required',
            'phone_code'=>'required',
            'phone_number'=>'required|unique:users,phone_number,'.$currentUser->id,
        ];
        
        if(in_array($currentUser->entity, array('corporate','private'))){
            $errors['company_name'] = 'required';
            $errors['description'] = 'required';
            $errors['location'] = 'bail|required|max:200';
            $errors['company_address'] = 'bail|required|string|max:200';
            $errors['registration_number'] = 'bail|required|string|max:200';
            $errors['vat_details'] = 'bail|required|string|max:200';
            $errors['no_of_employees'] = 'bail|required|numeric|min:1';
        }
        $this->validate($request,$errors);
        
        $currentUser->first_name = $request->first_name;
        $currentUser->last_name = $request->last_name;
        $currentUser->phone_code = $request->phone_code;
        $currentUser->phone_number = $request->phone_number;

        if(in_array($currentUser->entity, array('corporate','private'))){
            $currentUser->company_name = $request->company_name;
            $currentUser->description = $request->description;
            $currentUser->location = $request->location;
            $currentUser->company_address = $request->company_address;
            $currentUser->registration_number = $request->registration_number;
            $currentUser->vat_details = $request->vat_details;
            $currentUser->no_of_employees = $request->no_of_employees;
        }
        if($currentUser->save()){
            return response()->json(['status'=>true,'message'=>'Profile updated successfully.'], 200);
        }
        return response()->json(['status'=>false,'message'=>'Profile not updated. Please try again later.'], 200);
    }

    public function addGstVatDetails(Request $request){
        $currentUser=$this->user->getCurrentUser();
        $countries=$this->appsCountry->all();
        return view('web.client.profile.gst', compact('countries','currentUser'));
    }

    public function saveGstVatDetails(Request $request){
        $currentUser=$this->user->getCurrentUser();
        $this->validate($request,[
            'invoice_country_code'=>'required',
            'country_of_operation'=>'required',
            'country_of_origin'=>'required',
            'gst_vat_applicable'=>'bail|required|in:yes,no',
            'vat_gst_number'=>'bail|required_if:gst_vat_applicable,yes',
            'vat_gst_rate'=>'bail|required_if:gst_vat_applicable,yes|max:100|numeric',
        ]);

        $currentUser->invoice_country_code = $request->input('invoice_country_code');
        $currentUser->country_of_operation = $request->input('country_of_operation');
        $currentUser->country_of_origin = $request->input('country_of_origin');
        $currentUser->gst_vat_applicable = $request->input('gst_vat_applicable');
        if($request->input('gst_vat_applicable')=='yes'){
            $currentUser->vat_gst_number = $request->input('vat_gst_number');
            $currentUser->vat_gst_rate = $request->input('vat_gst_rate');
        }else{
            $currentUser->vat_gst_number = null;
            $currentUser->vat_gst_rate = null;
        }

        if($currentUser->save()){
            return response()->json(['status'=>true,'message'=>'Details updated successfully.'], 200);
        }
        return response()->json(['status'=>false,'message'=>'Details not updated. Please try again later.'], 200);
    }


}
