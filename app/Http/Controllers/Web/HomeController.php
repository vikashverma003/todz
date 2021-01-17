<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Session,Auth;
use App\User;
use App\Models\SiteContent;
use App\Models\Visit;
use App\Events\ProjectMessageEvent;
class HomeController extends Controller
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
       
      //  event(new ProjectMessageEvent(3,'34543tf53et',"Hello"));
    //    $redis = \LRedis::connection();
	// 	$data = ['message' => "dsfasdfsaf", 'user' => "Rakshasdfjlasfj"];
	// 	dd($redis->publish('message', json_encode($data)));
        return view('web.home.index');
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
        //
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
    public function socialWeb(Request $request)
    {
        $data = Session::get('data');
        $facebook_id = '';
        $linkedin_id = '';
        $existing = User::where('facebook_id',$data['id'])->orWhere('linkedin_id',$data['id'])->first();
        if(!is_null($existing))
        {

            if($existing->account_status == config('constants.account_status.IN_ACTIVE'))
            {
                return redirect(route('login'))->with('error', 'Not Approved By Admin') ;
            }
            else if($existing->account_status == config('constants.account_status.BLOCK'))
            {
                return redirect(route('login'))->with('error', 'Blocked by Admin') ;
            }
            else if($existing->account_status == config('constants.account_status.DEACTIVATE_ACCOUNT'))
            {
                
                return redirect()->back()->with('error', 'Your account has been deactivated') ;
                //return redirect(route('login'))->with('error', 'Your account has been deactivated');
            }
        }
        if($data['provider'] == 'facebook'){
            $facebook_id = $data['id'];
            $email = $data['email']??'';
            $first_name = $data['name'];
            $last_name = '';
        }
        else{
            $linkedin_id = $data['id'];
            $email = $data['emailAddress']??'';
            $first_name = $data['firstName']['localized']['en_US'];
            $last_name = $data['lastName']['localized']['en_US'];
        }
        if($email != '')
        {

            $existingUser = User::where('email',trim($email))->first();
           if(is_null($existingUser)){
 			return redirect('login')->with('error', 'User Not register with social link') ;

           }
            if($existingUser)
            {
                if($data['provider'] == 'facebook'){
                    $update = User::where('email',$email)->update([
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'facebook_id' => $facebook_id,
                    ]);
                }
                else{
                    $update = User::where('email',$email)->update([
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'linkedin_id' => $linkedin_id
                    ]);
                }
                if(Auth::loginUsingId($existingUser->id))
                {
                    return redirect(route('client_dashboard'));
                }
            }
            else
            {
            	
                $create = $this->user->create([
                        'first_name'=>$first_name,
                        'last_name' => $last_name,
                        'phone_code'=>$data['phone_code']??'',
                        'phone_number'=>$data['phone_number']??'',
                        'email'=>$data['email']??'',
                        'password'=>'',
                        'role'=>$data['role']??config('constants.role.CLIENT'),
                        'profile_image'=>$data['profile_image']??'',
                        'account_status'    => config('constants.account_status.ACTIVE'),
                        'facebook_id' =>$facebook_id,
                        'linkedin_id' => $linkedin_id,
                        'registration_step'=> 2
                    ]);
                    if(Auth::loginUsingId($create->_id))
                    {
                        return redirect(route('home'));
                    }
            }
        }
        else
        {
        	return redirect('login')->with('error', 'User Not register with social link') ;

            if($data['provider'] == 'facebook')
            {
                $check = User::where('facebook_id',$data['id'])->first();
                if($check)
                {
                    $update = User::where('facebook_id',$data['id'])->update([
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email'      => $email??$check->email,
                    ]);
                    if(Auth::loginUsingId($check->id))
                    {
                        return redirect(route('client_dashboard'));
                    }
                }
                else{
                    $create = $this->user->create([
                        'first_name'=>$first_name,
                        'last_name' => $last_name,
                        'phone_code'=>$data['phone_code']??'',
                        'phone_number'=>$data['phone_number']??'',
                        'email'=>$email??'',
                        'password'=>'',
                        'role'=>$data['role']??config('constants.role.CLIENT'),
                        'profile_image'=>$data['profile_image']??'',
                        'account_status'    => config('constants.account_status.ACTIVE'),
                        'facebook_id' => $facebook_id,
                        'registration_step'=> 2
                    ]);
                    if(Auth::loginUsingId($create->id))
                    {
                        return redirect(route('client_dashboard'));
                    }
                }
            }
            elseif($data['provider'] == 'linkedin')
            {
            	
                $check = User::where('linkedin_id',$data['id'])->first();
                if($check)
                {
                    $update = User::where('linkedin_id',$data['id'])->update([
                        'first_name'=>$first_name,
                        'last_name' => $last_name,
                        'email'      => $email??'',
                    ]);
                    if(Auth::loginUsingId($check->id))
                    {
                        return redirect(route('client_dashboard'));
                    }
                }
                else{
                    $create = $this->user->create([
                        'first_name'=>$first_name,
                        'last_name' => $last_name,
                        'phone_code'=>$data['phone_code']??'',
                        'phone_number'=>$data['phone_number']??'',
                        'email'=>$email??'',
                        'password'=>'',
                        'role'=>$data['role']??config('constants.role.CLIENT'),
                        'profile_image'=>$data['profile_image']??'',
                        'account_status'    => config('constants.account_status.ACTIVE'),
                        'linkedin_id' => $data['id'],
                        'registration_step'=> 2
                    ]);
                    if(Auth::loginUsingId($create->id))
                    {
                        return redirect(route('client_dashboard'));
                    }
                }
            }
        }
        return redirect('login')->with('error', 'Not able to login') ;

    }

    public function thanksPage(){
        return view('web.home.thanks');
    }

    public function categories(){
        return view('web.home.category');
    }

    // return all faq create by admin
    public function getFaqs(Request $request){
        $categories = \App\Models\Faq::distinct('category')->select('category')->orderBy('id','asc')->get();

        $data = \App\Models\Faq::select('title','content','category','id');
        if($request->filled('category')){
            $data->where('category', $request->input('category'));
        }
        $data = $data->orderBy('id','asc')->get();
        return view('web.site-content.faq', compact('data','categories'));
    }

    public function getAboutUs (){
        $data = SiteContent::where('type','content')->where('key','aboutus')->value('value');
        return view('web.site-content.aboutus', compact('data'));
    }

    public function getOurProcess (){
        $data = SiteContent::where('type','content')->where('key','ourprocess')->value('value');
        return view('web.site-content.ourprocess', compact('data'));
    }

    public function getContactUs (){
        $data = SiteContent::where('type','content')->where('key','contactus')->value('value');
        return view('web.contactus.index', compact('data'));
    }

    public function saveContactUs(Request $request){
        $errors = [
            'name'  => 'bail|required|string|max:100',
            'email'=>'bail|required|email|max:100',
            // 'purpose'=>'bail|required|string',
            'message'=>'bail|required|string|min:2|max:1000',
        ];
        $this->validate($request, $errors);
        try{
            $object =  new \App\Models\Contacts;
            $object->name = $request->name;
            $object->email = $request->email;
            $object->purpose = 'enquiry';
            $object->message = $request->message;
            if($object->save()){
                return redirect()->back()->with('success','Your query has been saved. we will revert you soon.');
            }
            return redirect()->back()->with('error','Something went wrong. Please try again later.');
            
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
        
    }

    public function getPrivacyPolicy (){
        $data = SiteContent::where('type','content')->where('key','privacypolicy')->value('value');
        return view('web.site-content.privacypolicy', compact('data'));
    }
    public function getAdbPage (){
        $data = SiteContent::where('type','content')->where('key','adb')->value('value');
        return view('web.site-content.adb', compact('data'));
    }
    public function getPaymentSafetyPage (){
        $data = SiteContent::where('type','content')->where('key','paymentsafety')->value('value');
        return view('web.site-content.paymentsafety', compact('data'));
    }
    public function getWhyWorkWithUsPage (){
        $client = SiteContent::where('type','content')->where('key','whyworkwithclient')->value('value');
        $talent = SiteContent::where('type','content')->where('key','whyworkwithtalent')->value('value');
        return view('web.site-content.whyworkwithus', compact('client','talent'));
    }

    public function getTodderTermsService (){
        $data = SiteContent::where('type','content')->where('key','todderterms')->value('value');
        return view('web.site-content.talent-terms',compact('data'));
    }
    public function getClientTermsService (){
        $data = SiteContent::where('type','content')->where('key','clientterms')->value('value');
        return view('web.site-content.client-terms', compact('data'));
    }

    public function saveVisit(Request $request){
        $ip = request()->ip();
        $useragents = $request->server('HTTP_USER_AGENT');

        $object = new Visit;
        $object->ip_address = $ip;
        $object->agents = $useragents;
        if($object->save()){
            return response()->json(['status'=>true,'message'=>'saved'], 200);
        }
    }
}
