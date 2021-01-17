<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\TalentRepositoryInterface;
use Illuminate\Validation\Rule;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Mail\TestLinkShare;
use App\Mail\sendInterviewInvite;
use App\Mail\RejectNotice;
use App\Mail\AcceptNotice;
use App\Mail\ProfileCompleted;
use App\Mail\ProfileRejected;
use App\Mail\AptitudeCleared;
use App\Mail\AptitudeNotCleared;
use App\Mail\TechnicalCleared;
use App\Mail\TechnicalNotCleared;
use Mail;
use DB;
use App\Models\TalentAptitudeTest;
use App\Repositories\Interfaces\TestResultRepositoryInterface;
use App\Repositories\Interfaces\AppsCountryRepositoryInterface;
use App\Repositories\Interfaces\JobCategoryRepositoryInterface;
use \Carbon\Carbon;
use App\Models\TalentDocument;

class TalentController extends Controller
{
    use \App\Traits\ExpertRating;
    use \App\Traits\CommonUtil;

    public $permissionName;

    public function __construct(UserRepositoryInterface $user,
    TalentRepositoryInterface $talent,
    NotificationRepositoryInterface $notification,
    TestResultRepositoryInterface $testResult,
    TalentAptitudeTest $talentAptitudeTest,
    AppsCountryRepositoryInterface $appCountry,
    JobCategoryRepositoryInterface $jobCategory){
        $this->user=$user;
        $this->talent=$talent;
        $this->notification=$notification;
        $this->testResult=$testResult;
        $this->talentAptitudeTest=$talentAptitudeTest;
        $this->permissionName = 'talent_management_access';
        $this->appCountry=$appCountry;
        $this->jobCategory=$jobCategory;
    }
    
    public function index(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $user=Auth::guard('admin')->user();

        $usr= \App\User::where('role',config('constants.role.TALENT'))->where('registration_step',3);
        $inputs = $request->all();
        $orderby = 'desc';

        if(isset($inputs['name'])){
            $usr->where('first_name', 'like', '%' . $inputs['name'] . '%')->orWhere('last_name', 'like', '%' . $inputs['name'] . '%');
        }
        if(isset($inputs['email'])){
            $usr->where('email', 'like', '%' . $inputs['email'] . '%');
        }
        if(isset($inputs['todz_id'])){
            $usr->where('todz_id', 'like', '%' . $inputs['todz_id'] . '%');
        }
        if(isset($inputs['phone'])){
            $usr->where('phone_number', 'like', '%' . $inputs['phone'] . '%');
        }
        // account status 
        if(isset($inputs['status'])){
            $usr->whereIn('account_status',$inputs['status']);
        }
        if(isset($inputs['country'])){
            if(count($inputs['country']) && $inputs['country'][0]!=''){
                $usr->whereIn('country',$inputs['country']);
            }
        }
        if(isset($inputs['job_category'])){
            if(count($inputs['job_category'])>0 && $inputs['job_category'][0]!='')
            {
                
                $usr->whereHas('talent',function($q) use($inputs){
                    $q->whereIn('job_field',$inputs['job_category']);
                });
            }
        }
        
        // test status filter
        if(isset($inputs['test_status']))
        {
            $testStatus = $inputs['test_status'];
            // if(count($testStatus)>0 && $testStatus[0]!=''){

            //     $usr->whereHas('talent',function($q) use($testStatus){
            //         $q->whereIn('is_technical_test',$testStatus)
            //         ->orWhereIn('is_aptitude_test',$testStatus)
            //         ->orWhereIn('is_profile_screened',$testStatus)
            //         ->orWhereIn('is_interview',$testStatus);
            //     });
            // }
            


            if($inputs['test_status']==2){
                $usr->whereHas('talent',function($q){
                    $q->where('is_technical_test',2)->orWhere('is_aptitude_test',2)
                    ->orWhere('is_profile_screened',2)->orWhere('is_interview',2);
                });
            }
            else if($inputs['test_status']==0)
            {
                $usr->whereHas('talent',function($q){
                    $q->where('is_technical_test',0)->where('is_aptitude_test',0)
                    ->where('is_profile_screened',0)->where('is_interview',0);
                });
            }else if($inputs['test_status']==1){
                $usr->whereHas('talent',function($q){
                    $q->where('is_technical_test',1)->where('is_aptitude_test',1)
                    ->where('is_profile_screened',1)->where('is_interview',1);
                });
            }else if($inputs['test_status']==3){
                $usr->whereHas('talent',function($q){
                 $q->where('is_technical_test',0)->where('is_aptitude_test',0)
                 ->where('is_profile_screened',1)->where('is_interview',0);
                });
            }else if($inputs['test_status']==5){
                $usr->whereHas('talent',function($q){
                 $q->where('is_technical_test',0)->where('is_aptitude_test',1)
                 ->where('is_profile_screened',1)->where('is_interview',0);
                });
            }else if($inputs['test_status']==4){
                $usr->whereHas('talent',function($q){
                 $q->where('is_technical_test',1)->where('is_aptitude_test',1)
                 ->where('is_profile_screened',1)->where('is_interview',0);
                });
            }
            //$usr->where('account_status',$inputs['test_status']);
        }
        if(isset($inputs['orderby'])){
            $orderby = $inputs['orderby'];
        }

        if($request->filled('start') && $request->filled('end'))
        {
            $date1 = str_replace('/', '-', $request->start);
            $date1 = date('Y-m-d', strtotime($date1));
            $date2 = str_replace('/', '-', $request->end);
            $date2 = date('Y-m-d', strtotime($date2));
            
            $usr->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2);
        }
        elseif ($request->filled('start')) {
            $date = str_replace('/', '-', $request->start);
            $date = date('Y-m-d', strtotime($date));
            $usr->whereDate('created_at','>=' ,$date);
        }
        elseif($request->filled('end')){
            $date = str_replace('/', '-', $request->end);
            $date = date('Y-m-d', strtotime($date));
            $usr->whereDate('created_at','<=' ,$date);
        }else{}

        $talents = $usr->orderBy('id',$orderby)->paginate(25);
        if($request->ajax()){
            return view('admin.talent.list', compact('talents'));
        }
        $allCountries= $this->appCountry->all();
        $alljobcatetory=$this->jobCategory->all();
        return view('admin.talent.index', ['title' => 'Talent Manager','user'=>$user,'talents'=>$talents,'allCountries'=>$allCountries,'alljobcatetory'=> $alljobcatetory]);
    }

    public function edit(Request $req,$id){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $testResponse = [];
        $testResponse=$this->getExpertTests();
        $tests= isset($testResponse->response->result->records) ? $testResponse->response->result->records : [];
        $user=Auth::guard('admin')->user();
        $title="Talent Manager";
        $talent = $this->user->getUserById($id);
        $result=$this->testResult->getUserTest($talent->todz_id);
        // dd($result);
        return view('admin.talent.edit',['title' => $title,'user'=>$user,'talent'=>$talent,'tests'=>$tests,'results'=>$result,'testResponse'=>$testResponse]);
    }

    public function edit_docx(Request $request,$id){

         $talent_document=TalentDocument::where('user_id','=',$id)->first();
        return view('admin.talent.edit_docx', compact('talent_document'));

    }
    public function show(Request $req,$id){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $user=Auth::guard('admin')->user();
        $title="Talent Manager";
        $talent = $this->user->getUserById($id);
        if($talent->role!='talent'){
            return redirect('404');
        }
        $documents = \App\Models\TalentDocument::where('user_id', $id)->get();
        $projects  = \App\Models\Project::where('talent_user_id', $id)->with(['client'])->get();

        return view('admin.talent.show', compact('talent','title','user','documents','projects'));
    }

    public function update(Request $req){
        
    }

    public function profileScreening(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $request->validate([
            'user_id'=>'required',
            'status'=>['required',Rule::in([config('constants.test_status.PENDING'),config('constants.test_status.APPROVED'),config('constants.test_status.DECLINED')])]

        ]);
        $user=$this->user->getUserById($request->user_id);
       
        $this->talent->profileScreening($request->all());
        if($request->status!=config('constants.test_status.PENDING')){
            $type=$request->status==config('constants.test_status.APPROVED')?config('notifications.notification_type.PROFILE_SCREENING_APPROVED'):config('notifications.notification_type.PROFILE_SCREENING_FAIL');
            $message=$request->status==config('constants.test_status.APPROVED')?config('notifications.notification_message.PROFILE_SCREENING_APPROVED'):config('notifications.notification_message.PROFILE_SCREENING_FAIL');
            
            $this->notification->create([
                'to_id'=>$request->user_id,
                'from_id'=>$user->id,
               'type'=> $type,
               'ref'=>null,
               'message'=>$message,
               ]);
            $subject = $message;
            if($type == config('notifications.notification_type.PROFILE_SCREENING_APPROVED'))
            {
                Mail::to($user->email)->send(new ProfileCompleted($user,$subject));
            }else
            {
                Mail::to($user->email)->send(new ProfileRejected($user,$subject));
            }
        }
        return redirect()->back();
    }

    public function attachAptitudeTest(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $request->validate([
            'user_id'=>'required',
            'aptitude_test_id'=>'required'

        ]);
        try{
        DB::beginTransaction();
        $user=$this->user->getUserById($request->user_id);
        $this->talentAptitudeTest->createTest([
            'user_id'=>$request->user_id,
            'talent_id'=>  $user->talent->id,
            'test_id'=>$request->aptitude_test_id
        ]);
       // $this->talent->aptitudeTestAttach($request->all());
        //$test_id,$todz_id,$test_booking_id
      
        $testDetail=$this->createTestLink($request->aptitude_test_id,$user->todz_id,'APT_'.$user->todz_id);
        $subject='Aptitude Test Mail';
        Mail::to($user->email)->send(new TestLinkShare($user,$testDetail->response->info->ticket,$subject));
        DB::commit();
        $this->notification->create([
            'to_id'=>$request->user_id,
            'from_id'=>$user->id,
           'type'=> config('notifications.notification_type.APTITUDE_TEST_MAIL'),
           'ref'=>null,
           'message'=>config('notifications.notification_message.APTITUDE_TEST_MAIL'),
           ]);
        return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back();
        }
    }
    public function aptitudeAction(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $request->validate([
            'user_id'=>'required',
            'status'=>['required',Rule::in([config('constants.test_status.PENDING'),config('constants.test_status.APPROVED'),config('constants.test_status.DECLINED')])],
            'aptitude_result' => 'required'

        ]);

        $this->talent->aptitudeAction($request->all());

        if($request->status!=config('constants.test_status.PENDING'))
        {
            $user=$this->user->getUserById($request->user_id);

            $type=($request->status==config('constants.test_status.APPROVED')) ? config('notifications.notification_type.APTITUDE_TEST_APPROVED') : config('notifications.notification_type.APTITUDE_TEST_FAIL');
            $message=($request->status==config('constants.test_status.APPROVED'))?config('notifications.notification_message.APTITUDE_TEST_APPROVED'):config('notifications.notification_message.APTITUDE_TEST_FAIL');
            
            $this->notification->create([
                'to_id'=>$request->user_id,
                'from_id'=>$user->id,
                'type'=> $type,
                'ref'=>null,
                'message'=>$message,
            ]);
            
            $subject = $message;
            if($type == config('notifications.notification_type.APTITUDE_TEST_APPROVED'))
            {
                Mail::to($user->email)->send(new AptitudeCleared($user,$subject));
            }else
            {
                Mail::to($user->email)->send(new AptitudeNotCleared($user,$subject));
            }
        }

        return redirect()->back();
    }

    public function attachTechnicalTest(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $request->validate([
            'user_id'=>'required',
            'technical_test_id'=>'required'

        ]);

        try{
            DB::beginTransaction();
            $user=$this->user->getUserById($request->user_id);
            $this->talentAptitudeTest->createTest([
                'user_id'=>$request->user_id,
                'talent_id'=>  $user->talent->id,
                'test_id'=>$request->technical_test_id
            ]);
         //   $this->talent->technicalTestAttach($request->all());
            //$test_id,$todz_id,$test_booking_id
            
            $testDetail=$this->createTestLink($request->technical_test_id,$user->todz_id,'TEC_'.$user->todz_id);
            $subject='Technical Test Mail';
            Mail::to($user->email)->send(new TestLinkShare($user,$testDetail->response->info->ticket,$subject));
            DB::commit();
            $this->notification->create([
                'to_id'=>$request->user_id,
                'from_id'=>$user->id,
               'type'=> config('notifications.notification_type.TECHNICAL_TEST_MAIL'),
               'ref'=>null,
               'message'=>config('notifications.notification_message.TECHNICAL_TEST_MAIL'),
               ]);
            return redirect()->back();
            }catch(\Exception $e){
                DB::rollback();
                return redirect()->back();
            }
    }


    public function technicalAction(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $request->validate([
            'user_id'=>'required',
            'status'=>['required',Rule::in([config('constants.test_status.PENDING'),config('constants.test_status.APPROVED'),config('constants.test_status.DECLINED')])]

        ]);
        $this->talent->technicalAction($request->all());

        if($request->status!=config('constants.test_status.PENDING'))
        {
            $user = $this->user->getUserById($request->user_id);

            $type=($request->status==config('constants.test_status.APPROVED')) ? config('notifications.notification_type.TECHNICAL_TEST_APPROVED') : config('notifications.notification_type.TECHNICAL_TEST_FAIL');

            $message=($request->status==config('constants.test_status.APPROVED'))?config('notifications.notification_message.TECHNICAL_TEST_APPROVED'):config('notifications.notification_message.TECHNICAL_TEST_FAIL');
            
            $this->notification->create([
                'to_id'=>$request->user_id,
                'from_id'=>$user->id,
                'type'=> $type,
                'ref'=>null,
                'message'=>$message,
            ]);
            $subject = $message;
            
            if($type == config('notifications.notification_type.TECHNICAL_TEST_APPROVED'))
            {
                Mail::to($user->email)->send(new TechnicalCleared($user,$subject));
            }else
            {
                Mail::to($user->email)->send(new TechnicalNotCleared($user,$subject));
            }
        }

        return redirect()->back();
    }

    public function interviewAction(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $request->validate([
            'user_id'=>'required',
            'status'=>['required',Rule::in([config('constants.test_status.PENDING'),config('constants.test_status.APPROVED'),config('constants.test_status.DECLINED')])]

        ]);
        $this->talent->interviewAction($request->all());
        if($request->status!=config('constants.test_status.PENDING')){
            $user=$this->user->getUserById($request->user_id);
            $type=$request->status==config('constants.test_status.APPROVED')?config('notifications.notification_type.INTERVIEW_APPROVED'):config('notifications.notification_type.INTERVIEW_FAIL');
            $message=$request->status==config('constants.test_status.APPROVED')?config('notifications.notification_message.INTERVIEW_APPROVED'):config('notifications.notification_message.INTERVIEW_FAIL');
            
            $this->notification->create([
                'to_id'=>$request->user_id,
                'from_id'=>$user->id,
               'type'=> $type,
               'ref'=>null,
               'message'=>$message,
               ]);
             $subject = $message;
            if($type == config('notifications.notification_type.INTERVIEW_APPROVED'))
            {
                Mail::to($user->email)->send(new AcceptNotice($user,$subject));
            }else
            {
                Mail::to($user->email)->send(new RejectNotice($user,$subject));
            }
        }

        return redirect()->back();
    }

    public function udpate_hourly_price(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

       // $user=Auth::user();
        $talent=$this->talent->updatehourlyRate($request->user_id,$request->hourle_rate);

        return redirect()->back();
    }
    public function sendInterviewInvite(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $request->validate([
            'user_id'=>'required'
        ]);
        try{
            DB::beginTransaction();
            $user=$this->user->getUserById($request->user_id);
            $subject='Interview Invitation Mail';
            $invitation_link = "https://outlook.office365.com/owa/calendar/todZ@NETORGFT5807095.onmicrosoft.com/bookings/";
            Mail::to($user->email)->send(new sendInterviewInvite($user,$subject,$invitation_link));
            DB::commit();
            return redirect()->back();
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->back();
        }

    } 
    public function destroy(Request $red,$id){
        try{
            $this->user->delete($id);
            return response()->json([],200);
        }catch(\Exception $e){
            return response()->json([],419);
        }
        }

    public function export(Request $request){
        return (new \App\Exports\TalentExport)->download('talents.xlsx');
    }
    public function getSummary(Request $request){
        abort_unless($this->helperCheckPermission("financial_reports_access"), 403);
        
        $title = 'Talent';
        $user = Auth::guard('admin')->user();
        $inputs = $request->all();
        $orderby = 'desc';
        if(isset($inputs['orderby'])){
            $orderby = $inputs['orderby'];
        }
       $users= \App\User::where('role',config('constants.role.TALENT'))->where('registration_step',3);
        $adminRevenue = self::filters($users, $inputs, $request);
        $selectRaw = 'DATE_FORMAT(created_at,"%d-%m-%Y") as registration_date,COUNT(*) as count';
        $groupBy = 'registration_date';
        $orderBy = 'registration_date';
        $data = $users->selectRaw($selectRaw)->groupBy(DB::raw($groupBy))->orderBy('id',$orderby)->paginate(10);
        $allCountries= $this->appCountry->all();
        $alljobcatetory=$this->jobCategory->all();
        $talents = $data;
        
        if($request->ajax()){
            return view('admin.talent.summary.list',compact('data','talents'));
        }
        return view('admin.talent.summary.index',compact('data','title','user','allCountries','alljobcatetory','talents'));
    }
     private function filters($usr, $inputs, $request){
     
       if(isset($inputs['name'])){
            $usr->where('first_name', 'like', '%' . $inputs['name'] . '%')->orWhere('last_name', 'like', '%' . $inputs['name'] . '%');
        }
        if(isset($inputs['email'])){
            $usr->where('email', 'like', '%' . $inputs['email'] . '%');
        }
        if(isset($inputs['todz_id'])){
            $usr->where('todz_id', 'like', '%' . $inputs['todz_id'] . '%');
        }
        if(isset($inputs['phone'])){
            $usr->where('phone_number', 'like', '%' . $inputs['phone'] . '%');
        } 
        if(isset($inputs['status'])){
            $usr->where('account_status',$inputs['status']);
        }
        if(isset($inputs['country'])){
            $usr->whereIn('country',$inputs['country']);
        }
        if(isset($inputs['job_category'])){
            $usr->whereHas('talent',function($q) use($inputs){
                $q->where('job_field',$inputs['job_category']);
            });
        }
        
        if(isset($inputs['test_status'])){
            if($inputs['test_status']==2){
            $usr->whereHas('talent',function($q){
             $q->where('is_technical_test',2)->orWhere('is_aptitude_test',2)
             ->orWhere('is_profile_screened',2)->orWhere('is_interview',2);
            });
            }else if($inputs['test_status']==0){
                $usr->whereHas('talent',function($q){
                 $q->where('is_technical_test',0)->where('is_aptitude_test',0)
                 ->where('is_profile_screened',0)->where('is_interview',0);
                });
            }else if($inputs['test_status']==1){
                    $usr->whereHas('talent',function($q){
                        $q->where('is_technical_test',1)->where('is_aptitude_test',1)
                        ->where('is_profile_screened',1)->where('is_interview',1);
                       });
            }else if($inputs['test_status']==3){
                $usr->whereHas('talent',function($q){
                 $q->where('is_technical_test',0)->where('is_aptitude_test',0)
                 ->where('is_profile_screened',1)->where('is_interview',0);
                });
            }else if($inputs['test_status']==5){
                $usr->whereHas('talent',function($q){
                 $q->where('is_technical_test',0)->where('is_aptitude_test',1)
                 ->where('is_profile_screened',1)->where('is_interview',0);
                });
            }else if($inputs['test_status']==4){
                $usr->whereHas('talent',function($q){
                 $q->where('is_technical_test',1)->where('is_aptitude_test',1)
                 ->where('is_profile_screened',1)->where('is_interview',0);
                });
            }
            //$usr->where('account_status',$inputs['test_status']);
        }
        if(isset($inputs['orderby'])){
            $orderby = $inputs['orderby'];
        }

        if($request->filled('start') && $request->filled('end'))
        {
            $date1 = str_replace('/', '-', $request->start);
            $date1 = date('Y-m-d', strtotime($date1));
            $date2 = str_replace('/', '-', $request->end);
            $date2 = date('Y-m-d', strtotime($date2));
            
            $usr->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2);
        }
        elseif ($request->filled('start')) {
            $date = str_replace('/', '-', $request->start);
            $date = date('Y-m-d', strtotime($date));
            $usr->whereDate('created_at','>=' ,$date);
        }
        elseif($request->filled('end')){
            $date = str_replace('/', '-', $request->end);
            $date = date('Y-m-d', strtotime($date));
            $usr->whereDate('created_at','<=' ,$date);
        }else{}
        return $usr;
    }
    public function talentSummaryGraphs(Request $request){
        $start =  $request->start;
        $end = $request->end;
        $data = [];
        $diff = 35;
        $date1 = $date2 = '';
        if($start && $end){
            $date1 = str_replace('/', '-', $start);
            $date1 = date('Y-m-d', strtotime($date1));
            $date2 = str_replace('/', '-', $end);
            $date2 = date('Y-m-d', strtotime($date2));

            $dd1 = Carbon::parse($date1);
            $dd2 = Carbon::parse($date2);
            $diff = $dd1->diffInDays($dd2);
        }
        
        $projectLabel=[];
        $projectCount=[];
        $talentData = [];

        try{
            $users= \App\User::where('role',config('constants.role.TALENT'))->where('registration_step',3);
            if($diff < 32){
                $selectRaw = 'DATE_FORMAT(created_at,"%d-%m-%Y") as dateM, COUNT(*) as count';
                $groupBy = 'dateM';
                $orderBy = 'dateM';
                $list1 = 'count';
                $list2 = 'dateM';
                $talentData = $users->orderBy(DB::raw($orderBy), 'ASC')->selectRaw($selectRaw)->groupBy(DB::raw($groupBy));
                if($date1 && $date2){
                    $talentData = $talentData->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2)->get();
                }else{
                    $talentData = $talentData->get();
                }
            }else
            {
                $selectRaw = 'DATE_FORMAT(created_at,"%Y-%M") as monthM, COUNT(*) as count';
                $groupBy = 'monthM';
                $orderBy = 'monthM';
                $list1 = 'count';
                $list2 = 'monthM';
                $talentData = $users->orderBy(DB::raw($orderBy), 'ASC')->selectRaw($selectRaw)->groupBy(DB::raw($groupBy));
                if($date1 && $date2){
                    $talentData = $talentData->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2)->get();
                }else{
                    $talentData = $talentData->get();
                }
            }

            $talentResponse = [];

            if (count($talentData)) {
                foreach ($talentData as $key => $val) {
                    $talentResponse[] = ['label'=>$val[$list2],'value'=>number_format($val[$list1],2) ?? 0];
                }
            }
            $data['talentResponse'] = $talentResponse;

            return response()->json(['status'=>true,'data'=>$data], 200);
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()], 400);
        }
    }   
  
}
