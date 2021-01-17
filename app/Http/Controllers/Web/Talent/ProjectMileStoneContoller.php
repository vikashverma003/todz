<?php

namespace App\Http\Controllers\Web\Talent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\Interfaces\MilesloneRepositoryInterface;
use App\Repositories\Interfaces\MilestoneTimeLogRepositoryInterface;
use ProjectManager;
use App\Repositories\Interfaces\TimesheetRepositoryInterface;
use DB;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\ProjectPaymentRepositoryInterface;
use App\Models\Project;
use App\Models\Escalation;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Mail\NewEscalationAlert;
use App\Mail\TimeSheetCreate;
use Mail;
use App\Models\Milestone;
use App\Mail\MilestoneSubmitted;
use App\User;


class ProjectMileStoneContoller extends Controller
{
    use \App\Traits\CommonUtil;

   public function __construct(ProjectRepositoryInterface $project,MilesloneRepositoryInterface $milestone,
   MilestoneTimeLogRepositoryInterface $milestoneTimeLog,TimesheetRepositoryInterface $timesheet,UserRepositoryInterface $user,ProjectPaymentRepositoryInterface $projectPayment, NotificationRepositoryInterface $notification){
    $this->project=$project;
    $this->milestone=$milestone;
    $this->milestoneTimeLog=$milestoneTimeLog;
    $this->timesheet=$timesheet;
    $this->user=$user;
    $this->notification=$notification;
    $this->projectPayment=$projectPayment;
   }
    public function overview(Request $request,$id){
        $currentUser=\Auth::user();
        $project=$this->project->getProjectById($id);
        if(is_null( $project)){
            return redirect()->route('talent_dashboard');
        }
        $milestones=$this->milestone->getMileStone($id,$currentUser->id);
        $payments=$this->projectPayment->projectPayment($id);
        return view('web.talents.milestone.overview',compact('project','milestones','payments'));
    }

    /**
    * create milestone method
    */
    public function createMileStone(Request $request){

        $this->validate($request, [
            'project_id'=>'required',
            'title'  => 'required',
            'description'=>'required',
            'start_date'=>'required',
            'due_date'=>'required',
            //  'cost'=>'required',,
            'no_of_hours'=>'required'
        ]);
        $data=$request->all();
        $user=\Auth::user();
        $data['talent_user_id']=$user->id;
        $this->milestone->create($data);

        $name = \Auth::user()->first_name.' '.\Auth::user()->last_name;

        Mail::to(\Auth::user()->email)->send(new MilestoneSubmitted($name));


        return redirect('talent/milestone/overview/'.$request->project_id.'#milestones');
    }

    public function startTimer(Request $request){
        $request->validate([
            'milestone_id'=>'required',
          //  'status'=>'required'
        ]);
        $milestone=$this->milestone->show($request->milestone_id);
       $runningTask =$this->milestone->isAnyTaskRunning($milestone->project_id);
       if(!is_null($runningTask)){
         //  dd($runningTask->id,$request->milestone_id);
           if($runningTask->id==$request->milestone_id){
            $milestone->is_task_runing=config('constants.TRACKER_STATUS.PAUSE');
            $milestone->runing_time=$milestone->runing_time+(time()-$milestone->tracker_start_time);
            $milestone->tracker_start_time=null;
     
            $milestone->save();
            $updatedtime=ProjectManager::getRuningHours($milestone->runing_time);
            return response()->json(['status'=>2,'message'=>'Task Pause Successfully','updated_time'=>$updatedtime]);
           }else{
               return response()->json(['status'=>0,'message'=>'Other Task is in runing state']);
           }
       }else{
        $milestone->is_task_runing=config('constants.TRACKER_STATUS.START');
        $milestone->tracker_start_time=time();
        $milestone->save();
        $sec=ProjectManager::getRuningSe($milestone->project_id);
        return response()->json(['status'=>1,'message'=>'Task start Successfully','sec'=>$sec]);
       }
        dd($request->all());

    }

    public function createTimeSheet(Request $request){
        $request->validate([
            'milestone_id'=>'required',
         //   'document'=>'required',
            'description'=>'required',
            'hours'=>'required'
        ]);
      
        $loggedInUser=$this->user->getCurrentUser();
        $itimeSheet=$this->timesheet->is_incomplete($loggedInUser->id);
        $data=$request->all();
        $data['user_id']= $loggedInUser->id;
        if(is_null( $itimeSheet)){            
            $this->timesheet->create($data);            
            $project_id = \App\Models\Mileslone::where('id', $data['milestone_id'])->value('project_id');
            $owner_id = Project::where('id', $project_id)->value('user_id');
            // sent mail to client inform regarding timesheet creation
            $user = User::where('id', $owner_id)->first();
            $res = Mail::to($user->email)->send(new TimeSheetCreate($user));
            
        }else{
            $itimeSheet->milestone_id=$request->milestone_id;
            $itimeSheet->description=$request->description;
            $itimeSheet->hours=$request->hours;
            $itimeSheet->i_c=1;
            $itimeSheet->save();
            $project_id = \App\Models\Mileslone::where('id', $data['milestone_id'])->value('project_id');
            $owner_id = Project::where('id', $project_id)->value('user_id');
            // sent mail to client inform regarding timesheet creation
            $user = User::where('id', $owner_id)->first();
            $res = Mail::to($user->email)->send(new TimeSheetCreate($user));
        }
        return redirect()->back();
    }
    public function timesheetfiledelete(Request $request){
        $input =$request->all();
        $request->validate([
            'filename' => 'required',
        ]);
        $loggedInUser=$this->user->getCurrentUser();
        $itimeSheet=$this->timesheet->is_incomplete($loggedInUser->id);
        if(!file_exists(public_path(env('FILE_UPLOAD_PATH')).'/'.$request->filename)){
            return response()->json('error', 400);
        }
        if (!unlink(public_path(env('FILE_UPLOAD_PATH')).'/'.$request->filename)) { 
            return response()->json('error', 400);
        } 
        else { 
            if($request->filename==$itimeSheet->original_name){}
            $file->delete();
        }
            return response()->json('success', 200);
        } 


	
    public function fileUpload(Request $request){

        $input =$request->all();
		
        $request->validate([
            'file' => 'required|max:30000',
        ]);
	DB::beginTransaction();
        $loggedInUser=$this->user->getCurrentUser();
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName=$this->uploadGalery($image);
        }
        $itimeSheet=$this->timesheet->is_incomplete($loggedInUser->id);
        if(is_null($itimeSheet)){
        $this->timesheet->create([
            'user_id'=>$loggedInUser->id,
            'file'=> $imageName,
            'original_name'=>$image->getClientOriginalName(),
            'i_c'=>0
        ]);
        }else{
            $itimeSheet->document=$imageName;
            $itimeSheet->original_name=$image->getClientOriginalName();
            $itimeSheet->save();

        }
            DB::commit();
        if( $imageName ) {
        	return response()->json('success', 200);
        } else {
        	return response()->json('error', 400);
        }
    }

    // save escalation raised by talent respective to milestone
    public function raiseEscalation(Request $request){
        
        $this->validate($request, [
            'escalation_project_id'=>'required',
            'escalation_milestone_id'=>'required',
            'escalation_owner_id'=>'required',
            'comment'=>'bail|required|string|max:200',
        ]);

        $result = Escalation::create([
            'talent_id'=>\Auth::user()->id,
            'project_id'=>$request->input('escalation_project_id'),
            'milestone_id'=>$request->input('escalation_milestone_id'),
            'owner_id'=>$request->input('owner_id'),
            'comment'=>$request->input('comment'),
        ]);
        if($result){
            $data = [];
            $data['talent_email'] = \Auth::user()->email;
            $data['project_id'] = $request->input('escalation_project_id');
            // send mail to notify regarding new escalation
            Mail::to('info@tod-z.com')->send(new NewEscalationAlert($data, 1));
            
            $talent_data = [];
            $talent_data['name'] = \Auth::user()->first_name;
            $talent_data['id'] = $result->id;
            Mail::to(\Auth::user()->email)->send(new NewEscalationAlert($talent_data, 2));

            return response()->json(['status'=>true,'message'=>'The escalation is submitted successfully. We will revert you soon.'], 200);
        }
        return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again later.'], 200); 
    }

    // return pdf of milestone to todder
    public function milestoneInvoice($project_id, $project_payment_id){
        $todder = \Auth::user();
        $project = Project::where('id', $project_id)->where('talent_user_id',$todder->id)->firstOrFail();
        $payment = $this->projectPayment->detail($project_payment_id, $project_id);
        if(!$payment){
            return redirect('404');
        }
        $admincomission = \App\Models\AdminComission::first();
        $pdf = $this->project->returnTalentInvoicePdf($todder,$project, $payment, $admincomission);

        return $pdf->stream('invoice.pdf');
    }

    // get detail of projects which are either completed or disputed
    public function projectOverview(Request $request,$id){
        $currentUser=\Auth::user();
        $project = Project::where('id', $id)->where('talent_user_id',$currentUser->id)->firstOrFail();
        $milestones=$this->milestone->getMileStone($id,$currentUser->id);
        $payments=$this->projectPayment->projectPayment($id);
        return view('web.talents.projects.overview',compact('project','milestones','payments'));
    }

    /**
    *mark project as dispute by talent.
    **/
    public function markCloseOrDisputeProject(Request $request){
        $this->validate($request, [
            'project_id'=>'required',
            'request_type'=>'bail|required|string|in:complete,dispute',
            'rating'=>'bail|required_if:request_type,complete',
            'feedback'=>'bail|required_if:request_type,complete',
            'reason'=>'bail|required_if:request_type,dispute',
        ]);
        
        try{
            $allStatus = array(config('constants.project_status.HIRED'));
            // check 
            $project = $this->project->details($request->project_id);
            if(is_null($project)){
                return response()->json(['status'=>false,'message'=>'The project is not found in records.'], 200);
            }
            $authUser=\Auth::user();
            
            if($request->request_type =='complete')
            {
                if(in_array($project->status, $allStatus))
                {
                    $this->notification->create([
                        'to_id'=>$project->client->id,
                        'from_id'=>$authUser->id,
                        'type'=>config('notifications.notification_type.TALENT_REQUEST_MARK_COMPLETE_PROJECT'),
                        'ref'=>$project->id,
                        'message'=>sprintf(config('notifications.notification_message.TALENT_REQUEST_MARK_COMPLETE_PROJECT'), (config('constants.PROJECT_ID_PREFIX').$project->id)),
                    ]);

                    // save ratings
                    $ratingdata = [];
                    $ratingdata['project_id'] = $project->id; 
                    $ratingdata['given_by_user_id'] = $authUser->id; 
                    $ratingdata['rated_user_id'] = $project->client->id; 
                    $ratingdata['rating'] = $request->rating; 
                    $ratingdata['feedback'] = $request->feedback; 
                    $ratingdata['rating_given_by'] = $authUser->role; 
                    $this->project->giveProjectRating($ratingdata);

                    $project->todder_request_close_project = 1;
                    $project->status = config('constants.project_status.COMPLETED');
                    $project->save();

                    return response()->json(['status'=>true,'message'=>'Project requested to mark completed Successfully.','url'=>url(route('talent_dashboard'))], 200);
                }
                return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again later. Reason- Project Status '.$project->status], 200);
            }else
            {
                if($project->status == config('constants.project_status.DISPUTE')){
                    return response()->json(['status'=>false,'message'=>'The project already marked disputed'], 200);
                }
                
                $project->status = config('constants.project_status.DISPUTE');
                $project->todder_dispute_reason = $request->reason;
                $project->save();

                // send notification to client
                $this->notification->create([
                    'to_id'=>$project->client->id,
                    'from_id'=>$authUser->id,
                    'type'=>config('notifications.notification_type.PROJECT_MARK_DISPUTED_BY_TALENT'),
                    'ref'=>$project->id,
                    'message'=>sprintf(config('notifications.notification_message.PROJECT_MARK_DISPUTED_BY_TALENT'), (config('constants.PROJECT_ID_PREFIX').$project->id)),
               ]);

                return response()->json([
                    'status'=>true,
                    'message'=>'Project has been marked disputed.',
                    'url'=>url(route('talent_dashboard'))
                ], 200);
            }
        }
        catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()], 200);
        }
    }
}
