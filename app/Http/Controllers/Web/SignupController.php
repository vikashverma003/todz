<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use Illuminate\Contracts\Auth\Guard;
use Session;
use App\Mail\OTPMail;
use Mail;
use Carbon\Carbon;
use App\Repositories\Interfaces\AppsCountryRepositoryInterface;
use App\Mail\DeactivateAccount;
class SignupController extends Controller
{
    private $user;
    private $appsCountry;
    public function __construct(UserRepositoryInterface $user, CouponRepositoryInterface $coupon, AppsCountryRepositoryInterface $appsCountry){
        $this->user=$user;
        $this->coupon = $coupon;
        $this->appsCountry=$appsCountry;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'entity'  => 'required',
        ]);
        $countries=$this->appsCountry->all();

        return view('web.signup.index')->with(['entity' => $request->entity,'countries'=>$countries]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $errors = [
            'name'  => 'required',
            'email'=>'required|unique:users,email',
            'phone_code'=>'required',
            'phone_number'=>'required|unique:users,phone_number',
            'password'=>'bail|required|string|min:8',
            'terms_checkbox'=>'bail|required',
            'country'=>'bail|required',
        ];

        if($request->entity=='corporate' || $request->entity=='private'){
            $errors['company_name'] = 'required';
            $errors['description'] = 'required';
            $errors['location'] = 'bail|required|max:200';
            $errors['company_address'] = 'bail|required|string|max:200';
            $errors['registration_number'] = 'bail|required|string|max:200';
            $errors['vat_details'] = 'bail|required|string|max:200';
            $errors['no_of_employees'] = 'bail|required|numeric|min:1';
        }
        
        $this->validate($request, $errors,['terms_checkbox.required'=>'Please accept terms and conditions.']);
        $data=$request->all();
        $data['first_name']=$request->name;
        $data['role']=config('constants.role.CLIENT');
        if(isset($data['coupon']))
        {
            $coupon = $this->coupon->checkCoupon($request->coupon,config('constants.COUPON_TYPE.CLIENT'));
            if(!is_null($coupon)){
                $data['coupon_id'] = $coupon->id;
            }
        }
        try{
            $created_user=$this->user->create($data);
            auth()->login($created_user, true);
            return redirect()->route('email_varification')->with('success',"Account Created successfully");
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            dd($e->getMessage());
            return redirect()->back()->with('error',"Database error");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // send otp to user via mail for account verification purpose.
    public function emailVarification(Request $request){
        
        $currentUser=\Auth::user();
        if($currentUser->registration_step==2){
            return redirect()->route('client_dashboard');
        }
      
        $otp=rand(100000,999999);
        Session::put('OTP',  $otp);
        $otp_expiration = Carbon::now()->addMinutes(10);
        Session::put('otp_expiration',  $otp_expiration);
        
        Mail::to($currentUser->email)->send(new OTPMail($currentUser->first_name,$otp));

        return view('web.signup.email_verify',['currentUser'=> $currentUser,'otp'=> $otp]);
    }

    // public function validateEmailVarification(Request $request){
    //     $this->validate($request, [
    //         'verify_code'  => 'required',
    //     ]);
    // }

    // validate user's entered OTP
    public function validateOtp(Request $request){
        $currentUser=\Auth::user();
        $otp=Session::get('OTP');
        $otp_expiration = Session::get('otp_expiration');
        if(!$otp || !$otp_expiration){
            echo json_encode(['status'=>0,'Message'=>"OTP did not matched. Please resend the OTP."]);
        }
        if(Carbon::now() >$otp_expiration){
            echo json_encode(['status'=>0,'Message'=>"OTP is expired. Please resend the OTP."]);
        }
        
        if($request->code==$otp){
            $todz_id=strtoupper(substr(uniqid(),0,9));
            $currentUser->registration_step=2;
            $currentUser->todz_id=$todz_id;
            $currentUser->save();
            echo json_encode(['status'=>1,'Message'=>"Congratulations, Your unique tod-z id has been generated! You will be identified by this unique id on the platform and none of your details will be revealed!",'todz_id'=>$todz_id]);
        }else{
            echo json_encode(['status'=>0,'Message'=>"OTP did not matched"]);
        }
    }

    public function resendOtp(Request $request){
        $currentUser=\Auth::user();
        $otp=rand(100000,999999);
        Session::put('OTP', $otp);
        $otp_expiration = Carbon::now()->addMinutes(10);
        Session::put('otp_expiration',  $otp_expiration);

        Mail::to($currentUser->email)->send(new OTPMail($currentUser->first_name,$otp));
        echo json_encode(['status'=>1,'Message'=>"Otp Send successfully $otp"]);
    }
    
    public function checkAppliedCoupon(Request $request)
    {
        $input =$request->all();
        $request->validate([
            'code' => 'required',
        ]);
        $coupon = $this->coupon->checkCoupon($request->code,config('constants.COUPON_TYPE.CLIENT'));
        if(!is_null($coupon))
        {
            return response()->json(['success'=>1, 'coupon'=>$coupon, 'message'=>'Coupon Applied Successfully']);
        }
        return response()->json(['success'=>0, 'message'=>'Invalid Coupon']);
    }
    public function checkAppliedCouponClient(Request $request)
    {
         $input =$request->all();
        $request->validate([
            'code' => 'required',
        ]);
        $coupon = $this->coupon->checkCoupon($request->code,config('constants.COUPON_TYPE.CLIENT'));
        if(!is_null($coupon))
        {
            return response()->json(['success'=>1, 'coupon'=>$coupon, 'message'=>'Coupon Applied Successfully']);
        }
        return response()->json(['success'=>0, 'message'=>'Invalid Coupon']);
    }

    public function deactivateAccount(Request $request){
       try{
           
        $currentUser=\Auth::user();
        $currentUser->account_status=config('constants.account_status.DEACTIVATE_ACCOUNT');
        if($currentUser->save()){
            $subject="Account deactivation mail";
            Mail::to($currentUser->email)->send(new DeactivateAccount($currentUser,$subject));
            \Auth::logout();
            return response()->json(['status'=>1,'msg'=>'Your Account deactivate successfully']);
        }else{
            return response()->json(['status'=>0,'msg'=>'There is error in deactivate account']);
        }
    }catch(\Exception $e){
        dd($e->getMessage());
    }
    }
}
