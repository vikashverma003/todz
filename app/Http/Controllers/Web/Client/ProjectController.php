<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\SkillRepositoryInterface;
use App\Repositories\Interfaces\ProjectFileRepositoryInterface;
use DB;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Models\ProjectTalent;
use App\Models\Project;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Repositories\Interfaces\SavedUserCardRepositoryInterface;
use App\Repositories\Interfaces\ProjectPaymentRepositoryInterface;
use Auth;
use App\User;
use App\Models\AdminComission;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use App\Models\AdminRevenue;
use Mail;
use App\Mail\JobInvitation;
use App\Mail\JobPosted;
use App\Models\ProjectFile;
use App\Mail\RatingMail;

class ProjectController extends Controller
{
    use \App\Traits\CommonUtil;
    use \App\Traits\MangoPayManager;

    public function __construct(ProjectRepositoryInterface $project,UserRepositoryInterface $user,SkillRepositoryInterface $skill,ProjectFileRepositoryInterface $projectFile,
    NotificationRepositoryInterface $notification,ProjectTalent $projectTalent,
    TransactionRepositoryInterface $transaction,SavedUserCardRepositoryInterface $saveUserCard,
    ProjectPaymentRepositoryInterface $projectPayment, AdminComission $comission, CouponRepositoryInterface $coupon){
        $this->project=$project;
        $this->user=$user;
        $this->skill=$skill;
        $this->projectFile=$projectFile;
        $this->notification=$notification;
        $this->projectTalent=$projectTalent;
        $this->transaction=$transaction;
        $this->saveUserCard=$saveUserCard;
        $this->projectPayment=$projectPayment;
        $this->comission=$comission;
        $this->coupon = $coupon;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('web.client.project.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $loggedInUser=$this->user->getCurrentUser();
        $inCompletedProject=$this->project->getLatestIncompleteProject($loggedInUser->id);
        
        if(!is_null($inCompletedProject)){
            $this->projectFile->deleteProjectFiles($inCompletedProject->id);
        }
        return view('web.client.project.create');

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
            'title' => 'required',
            'description' => 'required',
            'duration_month' => 'required|numeric',
            'duration_day' => 'required|numeric',
            'cost' => 'required|numeric',
            //'project_file' => 'required',
            'skills.*'=>'required|exists:skills,id'
        ]);
        try{
            DB::beginTransaction();
            $data=$request->all();
            $loggedInUser=$this->user->getCurrentUser();
            $data['user_id']=$loggedInUser->id;
            $createdProject=$this->project->create($data);
            $skills =  array_unique($request->skills);
            $createdProject->skills()->sync($skills);

            \App\User::where('id', $loggedInUser->id)->update(['temp_todz_id'=>$this->generateTodzId()]);
            // $imageName=null;
            // if ($request->hasFile('project_file')) {
            //     $image = $request->file('project_file');
            //     $imageName=$this->uploadGalery($image);
            // }
            // $this->projectFile->create([
            //     'project_id'=>$createdProject->id,
            //     'file_name'=> $imageName
            // ]);
            DB::commit();
            return redirect()->route('step_2');
        }catch(\Exception $e){
            DB::rollback();
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $project=$this->project->show($id);
        if(is_null($project)){
            return redirect()->route('client_dashboard');
        }
        if($request->has('is_read')){
            $user=\Auth::user();
            $this->notification->readMark($user->id,$request->is_read);
        }
        //  dd($invitedProject);
        return view('web.client.dashboard.show',compact('project'));
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

    public function searchSkill(Request $request){
        $result=$this->skill->searchByName($request->keyward);
        echo view('web.client.project.list',['skills'=> $result])->render();
    }


    public function stepTwo(Request $request){
        $loggedInUser=$this->user->getCurrentUser();

        $inCompletedProject = $this->project->getLatestIncompleteProject($loggedInUser->id);
        if(!$inCompletedProject){
            return redirect()->route('client_dashboard');
        }
        if($request->isMethod('post'))
        {
            $result = array_unique($request->talents);
            $inCompletedProject->talents()->sync($result);
            return redirect()->route('step_3');
        }
        $skills_ids = $skills = [];
        $skills = $inCompletedProject->skills;
        foreach ($skills as $key => $value) {
            $skills_ids[] = $value->id;
        }
        
        $userss = User::where('role',config('constants.role.TALENT'));
        
        $talents_ids = \App\Models\TalentSkill::whereIn('skill_id', $skills_ids)->pluck('talent_id')->toArray();
        
        $talents_ids = array_unique($talents_ids);
        $temp_users = \App\Models\Talent::whereIn('id', $talents_ids)->pluck('user_id')->toArray();

        $users = $userss->where('account_status',config('constants.account_status.ACTIVE'))->where('registration_step',3)->testcomplete()->whereIn('id', $temp_users)->with(['talent'=>function($q){
            $q->orderBy('hours','desc');
        }])->get();
            
        // $availUsers = [];
        // foreach ($users as $key => $value) {
        //     $availUsers[] = $value;

        //     $startTime = $value->talent->available_start_date;
        //     $endTime = $value->talent->available_end_date;
        //     $diff = abs(strtotime($startTime) - strtotime($endTime));
        //     $years = floor($diff / (365*60*60*24));
        //     $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        
        //     $availUsers[]['time_available'] = $months;
        // }
        
        return view('web.client.project.step-2',compact('users'));
    }

    // project final step to move incomplete project to pending state.
    public function stepThree(Request $request){
        $loggedInUser = $this->user->getCurrentUser();
        if($request->isMethod('post'))
        {
            try{
                $inCompletedProject = $this->project->getLatestIncompleteProject($loggedInUser->id);
                $inCompletedProject->status=config('constants.project_status.PENDING');
                $inCompletedProject->save();
                /*Notifcation code */
                $loggedInUser=$this->user->getCurrentUser();
                foreach($inCompletedProject->talents as $talent){
                    /*Notifcation code */
                    $this->notification->create([
                        'to_id'=>$talent->id,
                        'from_id'=>$loggedInUser->id,
                        'type'=>config('notifications.notification_type.PROJECT_INVITATION'),
                        'ref'=>$inCompletedProject->id,
                        'message'=>sprintf(config('notifications.notification_message.PROJECT_INVITATION'),$loggedInUser->todz_id),
                    ]);
                    $talent_user = User::where('id', $talent->id)->first();
                    // sent invite mail to each user
                    $talent_name = $talent_user->first_name.' '.$talent_user->last_name;
                    Mail::to($talent_user->email)->send(new JobInvitation($talent_name));
                }

                $owner_name = $loggedInUser->first_name.' '.$loggedInUser->last_name;
                Mail::to($loggedInUser->email)->send(new JobPosted($owner_name));

                // delete all incomplete projects which are created till yesterday.
                $this->project->deleteIncompleteProjects($loggedInUser->id);
                
                return response()->json(['status'=>1]);
            }catch(Exception $e){
                return response()->json(['status'=>0, 'Message'=>"Something went wrong"]);
            }
        }

        $inCompletedProject = $this->project->getLatestIncompleteProject($loggedInUser->id);
        if(is_null($inCompletedProject)){
            return redirect()->route('client_dashboard');
        }
        $users=$this->user->getTalents();
        return view('web.client.project.step-3',compact('users','inCompletedProject'));
    }

    
    public function showCompleteProject(Request $request, $id,$todz_id){

        $talent=$this->user->getByTodzId($todz_id);
        $project=$this->project->show($id);
        if(is_null($project)){
            return redirect()->route('client_dashboard');
        }
        // get all payment details by project id
        $payments=$this->projectPayment->projectPayment($id);
        $ProjectDate = date_diff(date_create($project->created_at), date_create(date('Y-m-d')))->format("%a");
        $ProjectDate = (int)$ProjectDate;
       
        return view('web.client.dashboard.project',compact('project','todz_id','talent','payments','ProjectDate'));
    }

    public function sendRating($rating_number,$todz_id)
     {
        $user=User::where('todz_id','=',$todz_id)->first();
        $email=$user->email;
        Mail::to($email)->send(new RatingMail($rating_number,$user));   
        return response()->json(['status'=>true,'message'=>'Mail has been sent successfully','url'=>url(route('client_dashboard'))], 200);           
     }
    public function addAdditionalTodder(Request $request,$project_id){
        if($request->isMethod('post'))
        {
            $project=$this->project->show($project_id);
            $result = array_unique($request->talents);
            $project->talents()->sync($result);
           return redirect()->route('client_dashboard');
        
        }
        $project=$this->project->show($project_id);
        $user_ids=$project->talents->where('pivot_status','<>',config('constants.project_talent_status.REJECTED'))->pluck('id')->toArray();
       
        $users=$this->user->getTalents();
        return view('web.client.project.add-addtion-toder',compact('users','project','user_ids'));
    }

    public function fileUpload(Request $request){

        $input =$request->all();
		
        $request->validate([
            'file' => 'required|max:30000',
        ]);
	   DB::beginTransaction();
        $loggedInUser=$this->user->getCurrentUser();
        $data['user_id']=$loggedInUser->id;
        $createdProject=$this->project->create($data);

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName=$this->uploadGalery($image);
        }

        $check_file=ProjectFile::where('project_id','=',$createdProject->id)->first();
        if(!empty($check_file))
        {
    
            $delete_file_exist=ProjectFile::where('project_id','=',$createdProject->id)->delete();
        }

        $this->projectFile->create([
            'project_id'=>$createdProject->id,
            'file_name'=> $imageName,
            'original_name'=>$image->getClientOriginalName()
        ]);
            DB::commit();
        if( $imageName ) {
        	return response()->json('success', 200);
        } else {
        	return response()->json('error', 400);
        }
    }

    public function projectfiledelete(Request $request){
        $input =$request->all();
        $request->validate([
            'filename' => 'required',
        ]);
        $inCompletedProject=$this->project->getIncompleteProject();
        $file=$this->projectFile->findImageByOriginalName($request->filename,$inCompletedProject->id);
        if (!unlink(public_path(env('FILE_UPLOAD_PATH')).'/'.$file->file_name)) { 
            return response()->json('error', 400);
        } 
        else { 
            $file->delete();
            return response()->json('success', 200);
        } 
    }

    // hire todder
    public function hiredTodder(Request $request){
         $token=$this->token();

        if ($request->isMethod('post')) {
            
            $request->validate([
                'project_id' => 'required|exists:projects,id',
                'todz_id' => 'required|exists:users,todz_id',
            ]);
            $redirect_url=$request->fullUrl()."?project_id=".$request->project_id."&todz_id=".$request->todz_id;
            $loggedInUser=$this->user->getCurrentUser();
            if(is_null($loggedInUser->mangopayUser) || count($loggedInUser->mangopayCard)==0 ){
                return response()->json(['status'=>0,'msg'=>'Please setup your payment wallet and save your card to charge payment during hiring time.']);
            }
            $defaultCard=$this->saveUserCard->getDefaultCard($loggedInUser->id);
            if(is_null($defaultCard)  ){
                return response()->json(['status'=>0,'msg'=>'No Default Card setup. Please set your defaultCard']);
            }

            $project=$this->project->show($request->project_id);
            /*******************Pre Authurize Payment On Hiring*********************** */
            $todderUser=$this->user->getByTodzId($request->todz_id);
            
            $proTalent=$this->projectTalent->getProjectInfo($request->project_id,$todderUser->id);
           

            // check project duration
            if($proTalent->no_of_days>30){
                $cost=($proTalent->no_of_hours/2)*$todderUser->talent->hourly_rate;
                $is_full_charge=0;
            }else
            {
                $cost=$proTalent->no_of_hours*$todderUser->talent->hourly_rate;
                $is_full_charge=1;
            }

            DB::beginTransaction();
            
      
            $response=$this->project->hireTodder($loggedInUser->id,$request->project_id,$todderUser->id);
            if($response)
            {
                $this->project->paymentChargeFlag($loggedInUser->id,$request->project_id,$is_full_charge);
                // add extra admin commission
                $adminCommRes = self::addExtraAdminCommission($request->project_id, $cost);
                $finalAmount = ($cost + $adminCommRes['admin_comm_cut']);

                $addPaymentTo=$this->payInFromDirectCard($token->access_token,$loggedInUser->mangopayUser->mangopay_user_id,$loggedInUser->mangopayUser->mangopay_wallet_id,$finalAmount,$defaultCard->card_id,$redirect_url);

                $Status = array("SUCCEEDED");
                //   dd($addPaymentTo);
                if(isset($addPaymentTo->Status) && in_array($addPaymentTo->Status,$Status))
                {
                    $transactionPayment = $this->transaction->create([
                        'project_id'=>$request->project_id,
                        'from_user_id'=>null,
                        'payment_type'=>$addPaymentTo->Type,
                        'charge_from_card_id'=>$defaultCard->card_id,
                        'to_user_id'=>$loggedInUser->id,
                        'amount'=>$finalAmount,
                        'fees'=>0,
                        'transaction_id'=>$addPaymentTo->Id,
                        'response_json'=>$addPaymentTo,
                        'coupon_discount'=>$adminCommRes['couponValue'],
                        'transaction_type'=>'project',
                    ]);

                    self::transferAdminCommission($request->project_id, $adminCommRes['admin_comm_cut']);
               
                    //  $preauthurize=$this->preauthrizePayment($token->access_token,'79697259',50,'79763005');
                    /****************************************************************** */
                    /*Notifcation code */
                    $this->notification->create([
                        'to_id'=>$todderUser->id,
                        'from_id'=>$loggedInUser->id,
                        'type'=>config('notifications.notification_type.PROJECT_HIRED'),
                        'ref'=>$project->id,
                        'message'=>sprintf(config('notifications.notification_message.PROJECT_HIRED'),$loggedInUser->todz_id, $project->title),
                    ]);

                    DB::commit();
                    self::sendTodderHireReceipt($project, $transactionPayment, $proTalent);

                    /*Notifcation code */
                    return response()->json(['status'=>1,'msg'=>'Todder Hired Successfully']);
                }
                elseif(isset($addPaymentTo->Status) && $addPaymentTo->Status=='CREATED')
                {
                    DB::commit();
                    return response()->json(['status'=>2,'msg'=>$addPaymentTo->SecureModeRedirectURL]);
                   // return redirect($addPaymentTo->SecureModeRedirectURL);
                } 
                else if(!isset($addPaymentTo->Status)){
                    DB::rollback();
                    return response()->json(['status'=>0,'msg'=>json_encode($addPaymentTo->errors),'mark'=>'No response']);
                }else{ 
                    DB::rollback();
                    return response()->json(['status'=>0,'msg'=>$addPaymentTo->ResultMessage,'mark'=>'No result get']);
                }
            }else{
                DB::rollback();
                return response()->json(['status'=>0,'msg'=>'There is problem in hiring todders']);
            }
        }else
        {
            $token=$this->token();
            $transaction = $this->viewPayin($token->access_token,$request->transactionId);

            if( $transaction->Status=='SUCCEEDED')
            {
                $loggedInUser=$this->user->getCurrentUser();
                $defaultCard=$this->saveUserCard->getDefaultCard($loggedInUser->id);
                if(is_null($defaultCard)  ){
                    return response()->json(['status'=>0,'msg'=>'No Default Card setup.Please set your defaultCard']);
                }
                $todderUser=$this->user->getByTodzId($request->todz_id);
                $proTalent=$this->projectTalent->getProjectInfo($request->project_id,$todderUser->id);

                DB::beginTransaction();
                
                $response=$this->project->hireTodder($loggedInUser->id,$request->project_id,$todderUser->id);
                if($response)
                {
                    
                    if($proTalent->no_of_days>30){
                        $cost=($proTalent->no_of_hours/2)*$todderUser->talent->hourly_rate;
                        $is_full_charge=0;
                    }else{
                        $cost=$proTalent->no_of_hours*$todderUser->talent->hourly_rate;
                        $is_full_charge=1;
                    }
                    
                    $this->project->paymentChargeFlag($loggedInUser->id,$request->project_id,$is_full_charge);
                    $project=$this->project->show($request->project_id);
                    
                    // add extra admin commission
                    $adminCommRes = self::addExtraAdminCommission($request->project_id, $cost);
                    $AdminPayres = self::transferAdminCommission($request->project_id, $adminCommRes['admin_comm_cut']);
                    
                    $transactionPayment = $this->transaction->create([
                        'project_id'=>$request->project_id,
                        'from_user_id'=>null,
                        'payment_type'=>$transaction->Type,
                        'charge_from_card_id'=>$defaultCard->card_id,
                        'to_user_id'=>$loggedInUser->id,
                        'amount'=>$transaction->CreditedFunds->Amount/100,
                        'fees'=>0,
                        'transaction_id'=>$transaction->Id,
                        'response_json'=>$transaction,
                        'coupon_discount'=>$adminCommRes['couponValue'],
                        'transaction_type'=>'project',
                    ]);

                    /*Notifcation code */
                    $this->notification->create([
                        'to_id'=>$todderUser->id,
                        'from_id'=>$loggedInUser->id,
                        'type'=>config('notifications.notification_type.PROJECT_HIRED'),
                        'ref'=>$project->id,
                        'message'=>sprintf(config('notifications.notification_message.PROJECT_HIRED'),$loggedInUser->todz_id, $project->title),
                    ]);
                    
                    DB::commit();
                    self::sendTodderHireReceipt($project, $transactionPayment, $proTalent);

                        /*Notifcation code */
                    return redirect('client/project/'.$request->project_id.'/'.$request->todz_id.'/show?successPayment=1');
                }else{
                    DB::rollback();
                    return redirect('client/project/'.$request->project_id.'/'.$request->todz_id.'/show');
                }
            }else{
                return redirect('client/project/'.$request->project_id.'/'.$request->todz_id.'/show');
            }
        }
    }

     // transfer client's cut from client to admin
    private function transferAdminCommission($project_id, $amount){
        $token = $this->token();
        $logedInuser=\Auth::user();
        $adminMangoPay = $this->getAdminMangoPayAccount();
        $adminUserId = $this->returnAdminUser();
        if($amount==0){
            AdminRevenue::create([
                'project_id'=>$project_id,
                'from_user_id'=>$logedInuser->id,
                'amount'=>0,
                'transaction_id'=>0,
                'transaction_response'=>json_encode(['status'=>'insufficent amount in client wallet']),
                'commission_from'=>'client'
            ]);
            return ['status'=>0,'Message'=>'insufficent amount.'];
        }

        $transfer = $this->transferFromWalletToWallet($token->access_token,$logedInuser->mangopayUser->mangopay_user_id, $adminMangoPay->mangopay_user_id,$logedInuser->mangopayUser->mangopay_wallet_id,$adminMangoPay->mangopay_wallet_id,$amount);
        
        if(isset($transfer->Status) && $transfer->Status=='SUCCEEDED')
        {
            // // client commission entry
            AdminRevenue::create([
                'project_id'=>$project_id,
                'from_user_id'=>$logedInuser->id,
                'amount'=>$amount,
                'transaction_id'=>$transfer->Id,
                'transaction_response'=>json_encode($transfer),
                'commission_from'=>'client'
            ]);
            
            return ['status'=>1,'Message'=>'admin commission transfered successfully.'];
        }else{

            AdminRevenue::create([
                'project_id'=>$project_id,
                'from_user_id'=>$logedInuser->id,
                'amount'=>0,
                'transaction_id'=>0,
                'transaction_response'=>json_encode(['status'=>'Transaction failed']),
                'commission_from'=>'client'
            ]);
            return ['status'=>0,'Message'=>'Transaction failed.'];
        }
    }

    // add extra money in wallet as admin commission
    private function addExtraAdminCommission($project_id, $cost){
        $admin_comm_cut = 0;
        $loggedInUser=\Auth::user();
        $comission = $this->comission->getComission()->project_comission;

        $final_comm = (($comission*$cost)/100); 

        $admin_comm_cut = $final_comm;
        $couponValue = 0;
        if($loggedInUser->coupon_used<1)
        {
            $coupon_id = $loggedInUser->coupon_id;
            if($coupon_id){
                $couponDB = $this->coupon->getById($coupon_id);
                if($couponDB)
                {
                    $coupon_value = $couponDB->coupon_value;
                    $couponValue = $coupon_value;
                    $final_comm = (($comission*$coupon_value)/100);
                    $admin_comm_cut = (($final_comm*$cost)/100);
                    User::where('id', $loggedInUser->id)->update(['coupon_used'=>1]);
                }
            }
        }
        
        // save admin cut to project table
        $commProject = $this->project->details($project_id);
        $commProject->admin_commission = $admin_comm_cut;
        $commProject->save();

        return ['admin_comm_cut'=>$admin_comm_cut, 'couponValue'=>$couponValue];
    }

    public function add_remaining_payment(Request $request){
          
        if ($request->isMethod('post'))
        {
            $request->validate([
                'project_id' => 'required|exists:projects,id',
                'todz_id' => 'required|exists:users,todz_id',
            ]);
            $redirect_url=$request->fullUrl()."?project_id=".$request->project_id."&todz_id=".$request->todz_id;
            $loggedInUser=$this->user->getCurrentUser();
            if(is_null($loggedInUser->mangopayUser) || count($loggedInUser->mangopayCard)==0 ){
                return response()->json(['status'=>0,'msg'=>'Please setup your payment wallet and save your card to charge payment during hiring time.']);
            }
            $defaultCard=$this->saveUserCard->getDefaultCard($loggedInUser->id);
            if(is_null($defaultCard)  ){
                return response()->json(['status'=>0,'msg'=>'No Default Card setup.Please set your defaultCard']);
            }
            DB::beginTransaction();
            $todderUser=$this->user->getByTodzId($request->todz_id);
          
                $project=$this->project->show($request->project_id);
                /*******************Pre Authurize Payment On Hiring*********************** */
                $proTalent=$this->projectTalent->getProjectInfo($request->project_id,$todderUser->id);
                $token=$this->token();
                if($proTalent->no_of_days>30){
                    $cost=($proTalent->no_of_hours/2)*$todderUser->talent->hourly_rate;
                    $is_full_charge=1;
                }else{
                    return response()->json(['status'=>0,'msg'=>'You payment already charged']);
                }
                
                $this->project->paymentChargeFlag($loggedInUser->id,$request->project_id,$is_full_charge);
                
                // add extra admin commission
                $adminCommRes = self::addExtraAdminCommission($request->project_id, $cost);
                $finalAmount = ($cost + $adminCommRes['admin_comm_cut']);

                $addPaymentTo=$this->payInFromDirectCard($token->access_token,$loggedInUser->mangopayUser->mangopay_user_id,$loggedInUser->mangopayUser->mangopay_wallet_id,$finalAmount,$defaultCard->card_id,$redirect_url);
    
                $Status = array("SUCCEEDED");
                //   dd($addPaymentTo);
                if(isset($addPaymentTo->Status) && in_array($addPaymentTo->Status,$Status))
                {
                    $this->transaction->create([
                        'project_id'=>$request->project_id,
                        'from_user_id'=>null,
                        'payment_type'=>$addPaymentTo->Type,
                        'charge_from_card_id'=>$defaultCard->card_id,
                        'to_user_id'=>$loggedInUser->id,
                        'amount'=>$finalAmount,
                        'fees'=>0,
                        'transaction_id'=>$addPaymentTo->Id,
                        'response_json'=>$addPaymentTo,
                        'coupon_discount'=>$adminCommRes['couponValue'],
                        'transaction_type'=>'project',
                    ]);
                    
                    self::transferAdminCommission($request->project_id, $adminCommRes['admin_comm_cut']);

                    //  $preauthurize=$this->preauthrizePayment($token->access_token,'79697259',50,'79763005');
                    /****************************************************************** */
                    /*Notifcation code */
                    $this->notification->create([
                        'to_id'=>$todderUser->id,
                        'from_id'=>$loggedInUser->id,
                        'type'=>config('notifications.notification_type.PROJECT_HIRED'),
                        'ref'=>$project->id,
                        'message'=>sprintf(config('notifications.notification_message.PROJECT_HIRED'),$loggedInUser->todz_id, $project->title),
                    ]);
                    DB::commit();
                    /*Notifcation code */
                    return response()->json(['status'=>1,'msg'=>'Todder Hired Successfully']);
                }
                elseif(isset($addPaymentTo->Status) && $addPaymentTo->Status=='CREATED')
                {
                    return response()->json(['status'=>2,'msg'=>$addPaymentTo->SecureModeRedirectURL]);
                    // return redirect($addPaymentTo->SecureModeRedirectURL);
                } 
                else if(!isset($addPaymentTo->Status)){
                    DB::rollback();
                    //   dd("hello");
                    //    dd($addPaymentTo);
                    return response()->json(['status'=>0,'msg'=>json_encode($addPaymentTo->errors)]);
    
                }else
                {
                    DB::rollback();
                    //   dd("hello");
                    //    dd($addPaymentTo);
                    return response()->json(['status'=>0,'msg'=>$addPaymentTo->ResultMessage]);
                }
        }else
        {
            $token=$this->token();
            $transaction=$this->viewPayin($token->access_token,$request->transactionId);
            if( $transaction->Status=='SUCCEEDED')
            {
                $loggedInUser=$this->user->getCurrentUser();
                $defaultCard=$this->saveUserCard->getDefaultCard($loggedInUser->id);
                if(is_null($defaultCard)  ){
                    return response()->json(['status'=>0,'msg'=>'No Default Card setup.Please set your defaultCard']);
                }
                DB::beginTransaction();
                $todderUser=$this->user->getByTodzId($request->todz_id);
                      
                $project=$this->project->show($request->project_id);
                /*******************Pre Authurize Payment On Hiring*********************** */
                $proTalent=$this->projectTalent->getProjectInfo($request->project_id,$todderUser->id);
                $token=$this->token();
                if($proTalent->no_of_days>30){
                    $cost=($proTalent->no_of_hours/2)*$todderUser->talent->hourly_rate;
                    $is_full_charge=1;
                }else
                {
                    return response()->json(['status'=>0,'msg'=>'You payment already charged']);
                }
                $this->project->paymentChargeFlag($loggedInUser->id,$request->project_id,$is_full_charge);

                $project=$this->project->show($request->project_id);

                // add extra admin commission
                // $commProject = $this->project->details($request->project_id);
                $adminCommRes = self::addExtraAdminCommission($request->project_id, $cost);
                self::transferAdminCommission($request->project_id, $adminCommRes['admin_comm_cut']);

                $this->transaction->create([
                    'project_id'=>$request->project_id,
                    'from_user_id'=>null,
                    'payment_type'=>$transaction->Type,
                    'charge_from_card_id'=>$defaultCard->card_id,
                    'to_user_id'=>$loggedInUser->id,
                    'amount'=>$transaction->CreditedFunds->Amount/100,
                    'fees'=>0,
                    'transaction_id'=>$transaction->Id,
                    'response_json'=>$transaction,
                    'coupon_discount'=>$adminCommRes['couponValue'],
                    'transaction_type'=>'project',
                ]);
           
                /*Notifcation code */
                $this->notification->create([
                    'to_id'=>$todderUser->id,
                    'from_id'=>$loggedInUser->id,
                    'type'=>config('notifications.notification_type.PROJECT_HIRED'),
                    'ref'=>$project->id,
                    'message'=>sprintf(config('notifications.notification_message.PROJECT_HIRED'),$loggedInUser->todz_id, $project->title),
                ]);
                    DB::commit();
                    /*Notifcation code */
                return redirect('client/project/'.$request->project_id.'/'.$request->todz_id.'/show?successPayment=1');
            }else{
                return redirect('client/project/'.$request->project_id.'/'.$request->todz_id.'/show#milestones');
            }
        }
    }

    /**
    *end project in which talent not hired yet.
    **/
    public function deleteClientProject(Request $request){
        $this->validate($request, [
            'project_id'=>'required',
            'reason'=>'bail|required|string|max:200',
        ]);
        
        try{
            $allStatus = array(config('constants.project_status.PENDING'), config('constants.project_status.ACTIVE'), config('constants.project_status.IN-COMPLETE'));
            // check 
            $project = $this->project->show($request->project_id);
            if(is_null($project)){
                return response()->json(['status'=>false,'message'=>'The project is not found in records.'], 200);
            }
            $authUser=Auth::user();
            if(in_array($project->status, $allStatus)){

                foreach($project->talents as $talent){
                    $this->notification->create([
                        'to_id'=>$talent->id,
                        'from_id'=>$authUser->id,
                        'type'=>config('notifications.notification_type.PROJECT_DELETE_BY_CLIENT'),
                        'ref'=>$project->id,
                        'message'=>sprintf(config('notifications.notification_message.PROJECT_DELETE_BY_CLIENT'), (config('constants.PROJECT_ID_PREFIX').$project->id)),
                   ]);
                }
                $project->close_reason = $request->reason;
                $project->save();
                // delete project after saving close reason
                $project->delete();
                return response()->json(['status'=>true,'message'=>'The project is closed Successfully.'], 200);
            }
            else
            {
                // check if project is completed or on going. If project is in progress check payment is released or not.
                $remainingAmount = $this->project->checkProjectAllPaymentsRelease($project->id);
                if($remainingAmount > 0){
                    return response()->json(['status'=>false,'message'=>'Please clear milestones payments and then close the project.'], 200);
                }
                return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again later.'], 200);
            }
        }
        catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()], 200);
        }  
    }

    /**
    *close project in which talent is hired ie. mark as disputed or mark as completed.
    **/
    public function closeClientProject(Request $request){
        $this->validate($request, [
            'project_id'=>'required',
            'request_type'=>'bail|required|string|in:complete,dispute',
            'rating'=>'bail|required_if:request_type,complete',
            //'feedback'=>'bail|required_if:request_type,complete',
            //'reason'=>'bail|required_if:request_type,dispute',
        ]);
        
        try{
            $allStatus = array(config('constants.project_status.HIRED'));
            // check 
            $project = $this->project->show($request->project_id);
            if(is_null($project)){
                return response()->json(['status'=>false,'message'=>'The project is not found in records.'], 200);
            }
            $authUser=Auth::user();
            if(in_array($project->status, $allStatus))
            {
                // check if project is completed or on going. If project is in progress check payment is released or not.
                $remainingAmount = $this->project->checkProjectAllPaymentsRelease($project->id);
                if($remainingAmount > 0){
                    return response()->json(['status'=>false,'message'=>'Please clear milestones payments and then close the project.'], 200);
                }
                if($request->request_type =='complete')
                {
                    $this->notification->create([
                        'to_id'=>$project->talent_user_id,
                        'from_id'=>$authUser->id,
                        'type'=>config('notifications.notification_type.PROJECT_COMPLETED_BY_CLIENT'),
                        'ref'=>$project->id,
                        'message'=>sprintf(config('notifications.notification_message.PROJECT_COMPLETED_BY_CLIENT'), (config('constants.PROJECT_ID_PREFIX').$project->id)),
                    ]);

                    // save ratings
                    $ratingdata = [];
                    $ratingdata['project_id'] = $project->id; 
                    $ratingdata['given_by_user_id'] = $authUser->id; 
                    $ratingdata['rated_user_id'] = $project->talent_user_id; 
                    $ratingdata['rating'] = $request->rating; 
                    $ratingdata['feedback'] = $request->feedback; 
                    $ratingdata['rating_given_by'] = $authUser->role; 
                    $this->project->giveProjectRating($ratingdata);

                    $project->status = config('constants.project_status.COMPLETED');
                    $project->save();

                    return response()->json(['status'=>true,'message'=>'Project Closed Successfully.','url'=>url(route('client_dashboard'))], 200);
                }else
                {
                    // mark as disputed
                    $project->status = config('constants.project_status.DISPUTE');
                    $project->client_dispute_reason = $request->reason;
                    $project->save();

                    $this->notification->create([
                        'to_id'=>$project->talent_user_id,
                        'from_id'=>$authUser->id,
                        'type'=>config('notifications.notification_type.PROJECT_MARK_DISPUTED_BY_CLIENT'),
                        'ref'=>$project->id,
                        'message'=>sprintf(config('notifications.notification_message.PROJECT_MARK_DISPUTED_BY_CLIENT'), (config('constants.PROJECT_ID_PREFIX').$project->id)),
                   ]);
                    
                    return response()->json([
                        'status'=>true,
                        'message'=>'Project has been marked disputed.',
                        'url'=>url(route('client_dashboard'))
                    ], 200);
                }
            }
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again later. Reason- Project Status '.$project->status], 200);
        }
        catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()], 200);
        }
    }

    /**
    * Return pdf stream of client milestone invoice
    **/
    public function milestoneInvoice($project_id, $project_payment_id){
        
        $project = Project::where('id',$project_id)->where('user_id', Auth::user()->id)->firstOrFail();
        $payment = $this->projectPayment->detail($project_payment_id, $project_id);
        if(!$payment){
            return redirect('404');
        }
        $admincomission = $this->comission->getComission();
        $pdf =$this->project->returnClientInvoicePdf($project, $payment, $admincomission);

        return $pdf->stream('invoice.pdf');
    }

    // send receipt of todder hire via email to client
    public function sendTodderHireReceipt($project, $payment, $proTalent){
        // try{
            $logedInuser=$this->user->getCurrentUser();
            $email = $logedInuser->email;
            $client_name = $logedInuser->first_name;

            $talent = \App\Models\Talent::where('user_id',$project->talent_user_id)->first();
            $admincomission = $this->comission->getComission();
            
            $talentUser = User::where('id', $project->talent_user_id)->first();
            $talentUserGst = 0;
            if($talentUser->gst_vat_applicable=='yes'){
                $talentUserGst = $talentUser->vat_gst_rate;
            }

            $pdf = \PDF::loadView('pdfTemplate.talenthire-receipt', compact('project','payment','logedInuser','proTalent','talent','admincomission','talentUser','talentUserGst'));

            $data["email"]= $email;
            $data["subject"]='Todder Hire Receipt';
            $data["client_name"]=$client_name;

            \Mail::send('EmailTemplate.talenthire-receipt', $data, function($message)use($data,$pdf) {
                $message->to($data["email"], $data["client_name"])
                ->subject($data["subject"])
                ->attachData($pdf->output(), "Receipt.pdf");
            });
            
        // }catch(\Exception $exception){
        //     // 
        // }
    }
}
