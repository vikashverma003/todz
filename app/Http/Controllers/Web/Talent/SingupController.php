<?php

namespace App\Http\Controllers\Web\Talent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Auth;
use DB;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\TalentRepositoryInterface;
use App\Repositories\Interfaces\SkillRepositoryInterface;
use App\Repositories\Interfaces\TalentDocumentRepositoryInterface;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use App\Mail\OTPMail;
use App\Mail\NewTalentSignupNotifyAdmin;
use Mail;
use App\Repositories\Interfaces\JobCategoryRepositoryInterface;
use App\Repositories\Interfaces\AppsCountryRepositoryInterface;

class SingupController extends Controller
{
    use \App\Traits\CommonUtil;
    private $user;
    private $appsCountry;
    public function __construct(UserRepositoryInterface $user, TalentRepositoryInterface $talent, SkillRepositoryInterface $skill, TalentDocumentRepositoryInterface $talentDocument, JobCategoryRepositoryInterface $jobCategory, CouponRepositoryInterface $coupon, AppsCountryRepositoryInterface $appsCountry){
        $this->user=$user;
        $this->talent=$talent;
        $this->skill=$skill;
        $this->talentDocument=$talentDocument;
        $this->jobCategory=$jobCategory;
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
        $data = Session::get('data');
        if(!$data){
            return redirect('/');
        }
        $user_data = [];
        $user_data['facebook_id'] = '';
        $user_data['linkedin_id'] = '';
        if($data['provider'] == 'facebook'){
            $user_data['facebook_id'] = $data['id'];
            $user_data['email'] = $data['email'];
            $user_data['first_name'] = $data['name'];
        }
        else{
            $user_data['linkedin_id'] = $data['id'];
            $user_data['email'] = $data['emailAddress'];
            $user_data['first_name'] = $data['firstName']['localized']['en_US']??'';
            $user_data['last_name'] = $data['lastName']['localized']['en_US']??'';
        }

        $countries=$this->appsCountry->all();

        return view('web.talents.signup.index')->with(['data'=>$user_data,'countries'=>$countries]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $this->validate($request, [
            'name'  => 'required',
            'email'=>'required|unique:users,email',
            'phone_code'=>'required',
            'phone_number'=>'required|min:8|max:15|unique:users,phone_number',
            'password'=>'required|min:6',
            'terms_checkbox'=>'bail|required',
            'country'=>'bail|required',
        ],['terms_checkbox.required'=>'Please accept terms and conditions.']);

        

        try{
            $data=$request->all();
            $data['first_name']=$request->name;
            $data['role']=config('constants.role.TALENT');
            
            if(isset($data['coupon'])){
                $coupon = $this->coupon->checkCoupon($request->coupon,config('constants.COUPON_TYPE.TALENT'));
                if(!is_null($coupon))
                {
                    $data['coupon_id'] = $coupon->id;
                }
            }

            DB::beginTransaction();
            $created_user=$this->user->create($data);
            auth()->login($created_user, true);
            DB::commit();
            return response()->json(['status'=>true,'message'=>'Account Created successfully.','url'=>route('talent_email_verify')], 200);
        }
        catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again later.'], 200);
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

    public function emailVarification(Request $request){
        
        $currentUser=\Auth::user();
        if($currentUser->registration_step==2){
            return redirect()->route('signup_work');
        }
       
        $otp=rand(100000,999999);
        Session::put('OTP',  $otp);
        Mail::to($currentUser->email)->send(new OTPMail($currentUser->first_name,$otp));

      return view('web.talents.signup.email_verify',[ 'currentUser'=> $currentUser,'otp'=> $otp]);
    }

    public function emailVarificationResend(Request $request){
            
            $currentUser=\Auth::user();
            if($currentUser->registration_step==2){
                return redirect()->route('signup_work');
            }
           
            $otp=rand(100000,999999);
            Session::put('OTP',  $otp);
            Mail::to($currentUser->email)->send(new OTPMail($currentUser->first_name,$otp));
            
            return response()->json(['status'=>true,'message'=>'Otp has been resent successfully'], 200);
          //return view('web.talents.signup.email_verify',[ 'currentUser'=> $currentUser,'otp'=> $otp]);
        }


    
    public function validateOtp(Request $request){
        $currentUser=\Auth::user();
        $otp=Session::get('OTP');
           
        if($request->code==$otp){
            $todz_id=strtoupper(uniqid());
            $currentUser->registration_step=2;
          //  $currentUser->todz_id=$todz_id;
            $currentUser->save();
             echo json_encode(['status'=>1,'Message'=>"Congratulations, Your unique tod-z id has been generated! You will be identified by this unique id on the platform and none of your details will be revealed!",'todz_id'=>$todz_id]);
        }else{
            echo json_encode(['status'=>0,'Message'=>"Otp did not matched"]);
         }
    }

    public function signupWork(Request $request){
        
        $currentUser=\Auth::user();
        if ($request->isMethod('post'))
        {
            $request->validate([
                'job_field' => 'required',
                'job_title' => 'required',
                'work_experience' => 'required',
                'available_start_date' => 'required',
                'available_end_date' => 'required',
                'working_type' => 'required',
                'hours' => 'required',
                'skills' => 'required',
                'expected_hourly_rate'=>'bail|required|numeric'
            ]);
            $data=$request->all();
            $data['user_id']=$currentUser->id;
            $createdTalent=$this->talent->create($data);
            $todz_id=strtoupper(substr(uniqid(),0,9));
            $currentUser->registration_step=3;
            $currentUser->todz_id=$todz_id;
            $currentUser->expected_hourly_rate=$request->expected_hourly_rate;
            $currentUser->save();

            $skills = array_unique($request->skills);
            $createdTalent->skills()->sync($skills);

            // send mail to admin notify regarding new user signup. info@tod-z.com
            Mail::to('info@tod-z.com')->send(new NewTalentSignupNotifyAdmin($currentUser));

            return redirect()->route('talent_dashboard');
        }
        $jobCategories=$this->jobCategory->all();
        $this->talentDocument->deleteProjectFiles($currentUser->id);
        
        return view('web.talents.signup.signup_work',compact('jobCategories'));
    }
    public function searchSkill(Request $request){
        $result=$this->skill->searchByName($request->keyward);
        echo view('web.client.project.list',['skills'=> $result])->render();
    }


    public function fileUpload(Request $request){
        $input =$request->all();
        $request->validate([
            'file' => 'required|mimes:jpeg,png,jpg,txt',
        ]);
        DB::beginTransaction();
        $loggedInUser=$this->user->getCurrentUser();
        if ($request->hasFile('file')) 
        {
            $image = $request->file('file');
            $imageName=$this->uploadGalery_talent($image);
        }
        $this->talentDocument->create([
            'user_id'=>$loggedInUser->id,
            'file_name'=> $imageName,
            'original_name'=>$image->getClientOriginalName(),
            'type'=>'workReference'
        ]);
        DB::commit();
        if( $imageName ) {
            return response()->json('success', 200);
        } 
        else {
            return response()->json('error', 400);
        }
    }

    public function uploadTalentResume(Request $request){
        $input =$request->all();
        $request->validate([
            'file' => 'required|mimes:jpeg,png,jpg,txt',
        ]);
        DB::beginTransaction();
        $loggedInUser=$this->user->getCurrentUser();
        if ($request->hasFile('file')) 
        {
            $image = $request->file('file');
            $imageName=$this->uploadGalery_talent($image);
        }
        $this->talentDocument->create([
            'user_id'=>$loggedInUser->id,
            'file_name'=> $imageName,
            'original_name'=>$image->getClientOriginalName(),
            'type'=>'resume'
        ]);
        DB::commit();
        if( $imageName ) {
            return response()->json('success', 200);
        } 
        else {
            return response()->json('error', 400);
        }
    }

    public function filedelete(Request $request){
        $input =$request->all();
        $request->validate([
            'filename' => 'required',
        ]);
        $loggedInUser=$this->user->getCurrentUser();
        $file= $this->talentDocument->findImageByOriginalName($request->filename,$loggedInUser->id);
        if (!unlink(public_path(env('FILE_UPLOAD_PATH')).'/'.$file->file_name)) { 
            return response()->json('error', 400);
        } 
        else { 
            $file->delete();
            return response()->json('success', 200);
        } 
    }
    public function checkAppliedCoupon(Request $request)
    {
        $input =$request->all();
        $request->validate([
            'code' => 'required',
        ]);
        $coupon = $this->coupon->checkCoupon($request->code,config('constants.COUPON_TYPE.TALENT'));
        if(!is_null($coupon))
        {
            return response()->json(['success'=>1, 'coupon'=>$coupon, 'message'=>'Coupon Applied Successfully']);
        }
        return response()->json(['success'=>0, 'message'=>'Invalid Coupon']);
    }

}
