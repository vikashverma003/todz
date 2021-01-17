<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Mail\sendForgotPasswordLink;
use Auth, validate;
use Illuminate\Validation\Rule;
use App\User;
class LoginController extends Controller
{
    private $user;
    public function __construct(UserRepositoryInterface $user){
        $this->user=$user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('web.login.index');
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
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6',
          'role'=>['required',Rule::in([config('constants.role.CLIENT'),config('constants.role.TALENT')])]
           
                
        ]);
        if (!Auth::check())
        {
            $email=$request->get('email');
            $password=$request->get('password');
            $check_deactivation=User::where('email','=',$email)->where('account_status','=',3)->first();

            if(empty($check_deactivation))
            {
              if (Auth::attempt(['email' => $email, 'password' => $password,'role'=>$request->role,'account_status'=>config('constants.account_status.ACTIVE'),'block' => NULL], $request->has('remember'))){
                  return redirect()->route('client_dashboard');
              }else{
                  return redirect()->back()->with('error', 'Login credential is not valid ') ;
              }
            }
          else
          {
             return redirect()->back()->with('error', 'Your account has been deactivated') ;
          }            
        }
        else{
            return redirect()->route('client_dashboard');
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
    public function logout(){
        \Auth::logout();
        return redirect(\URL::previous());
    }
    public function forgotPassword(Request $request)
    {
        if($request->isMethod('post'))
        {
            $this->validate($request, [
                'email'=>'bail|required|email|exists:users',
            ],['email.exists'=>'The selected email does not exist.']);
            if(isset($request->email))
            {
                $check = $this->user->checkUserByEmail($request->email);
                if($check && !is_null($check))
                {
                    $token = md5(time().rand(0,1000).$check->id);
                    $update = $this->user->updateToken($token,$check->id);
                    $user = $this->user->getUserById($check->id);
                    // dd(env('MAIL_USERNAME'),env('MAIL_PASSWORD'),env('MAIL_FROM_ADDRESS'));
                    Mail::to($user->email)->send(new sendForgotPasswordLink($user));

                    return redirect()->back()->with('success', 'We have send an email to reset Password.') ;
                }
                return redirect()->back()->with('error', 'Please pass valid email address');
            }else{
                return redirect()->back()->with('error', 'Please enter valid email');
            }
        }
        return view('web.login.forgot-password');
    }

    public function resetPassword(Request $request)
    {

        if($request->isMethod('post'))
        {
            $this->validate($request, [
                'password'=>'required|min:8',
                'c_password'=>'required|min:8|same:password',
                'email_token' => 'required'
            ]);
            $user = $this->user->getUserByToken($request->email_token);
            $update = $this->user->resetPassword([
                'email_token' => $request->email_token,
                'password' => $request->password
            ]);
            if (Auth::attempt(['email' => $user->email, 'password' => $request->password,'account_status'=>config('constants.account_status.ACTIVE'),'block' => NULL]))
            {
                \Session::put('passwordChanged', 1);
                return redirect()->route('resetSuccess');
            }
        }

        $tkn = $request->tkn;
        $user = $this->user->getUserByToken($request->tkn);
        if($user && !is_null($user))
        {
            return view('web.login.reset-password',['tkn'=>$tkn]);
        }
        else
        {
            return redirect()->route('siteError', ['message'=>'The verification link expired.']);
        }
    }

    public function logintalent()
    {
        return view('web.talents.login.index');
    }

    // redirect to success page after user reset password successfully.
    public function resetSuccess(){
        $passwordChanged = \Session::get('passwordChanged');
        if($passwordChanged){
            \Session::forget('passwordChanged');
            return view('web.login.reset-success');
        }
        return redirect('404');
    }

    // redirect to custom site error page.
    public function siteError($message){
        return view('web.login.site-error', compact('message'));
    }
  


    public function dataImport(Request $request){
      // $useridsArray=\App\User::where('is_import_user',1)->pluck('id')->toArray();
      // \App\Models\Talent::whereIn('user_id',$useridsArray)->delete();
      // dd(\App\User::where('id','>',872)->get());
        $str = file_get_contents(public_path('users.json'));
        $json = json_decode($str, true);
        // dd($json);
        try{
        \DB::beginTransaction();
        foreach($json['users'] as $key=>$value){
          $u=\App\User::where('email',$value['email'])->where('is_import_user',1)->first();
          if(!is_null($u)){
              $u->created_at=date('Y-m-d H:i:s',intval($value['createdDate']/1000)); 
             if($u->country=='' || $u->country==null){
                $u->country=$value['country'];
                // $u->country=$value['otherCountry'];
             }
             $u->talent()
             ->update([
                'resume_file'=>$value['resume']??null,
                'workSample_file'=>$value['workSample']??null,
                'created_at'=>date('Y-m-d H:i:s',intval($value['createdDate']/1000))
             ]);


              $u->save();

        //     $todz_id=strtoupper(substr(uniqid(),0,9));

        // $createdUser=\App\User::create([
        //     'first_name'        =>$value['name'],
        //     'last_name'         =>'',
        //     'email'             =>$value['email']??null, 
        //     'password'          =>\Hash::make("qazxsw12345"),
        //     'phone_code'        =>'',
        //     'phone_number'      =>'',
        //     'account_status'    =>config('constants.account_status.BLOCK'),
        //     'role'              =>config('constants.role.TALENT'),
        //     'facebook_id'       =>null,
        //     'linkedin_id'       =>null,
        //     'registration_step' =>3,
        //     'entity'            =>'',
        //     'company_name'      =>'',
        //     'description'       =>'',
        //     'no_of_employees'   => 0,
        //     'coupon'            =>null,
        //     'coupon_id'         =>null,
        //     'location'=>null,
        //     'company_address'=>null,
        //     'registration_number'=>null,
        //     'vat_details'=>null,
        //     'country'=>$value['country']?$value['country']:$value['otherCountry']?$value['otherCountry']:null,
        //     'expected_hourly_rate'=>$value['price'] ?? 0,
        //     'is_import_user'=>1,
        //     'todz_id'=>$todz_id  
        // ]);
        // \App\Models\Talent::create([
        //     'user_id'=>$createdUser->id,
        //     'job_field'=>$value['jobCategory'],
        //     'job_title'=>$value['jobCategory'],
        //     'work_experience'=>null,
        //     'available_start_date'=>null,
        //     'working_type'=>round($value['daysMonthly']/5),
        //     'available_end_date'=>null,
        //     'hours'=>$value['hoursDaily'],
        //     'is_profile_screened'=>2
        // ]);
      }
      }
        \DB::commit();
die("success");
      }catch(\Exception $e){

        \DB::rollBack();
        dd($e->getMessage());
      }



    }
}
