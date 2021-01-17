<?php

namespace App\Http\Controllers\Web\Talent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Models\ProjectTalent;
use App\Repositories\Interfaces\MessageRepositoryInterface;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use Mail;
use App\Mail\JobAccepted;
use App\Mail\JobRejected;
use App\Mail\JobClosed;
use App\User;

class DashboardController extends Controller
{

   
    public function __construct(ProjectRepositoryInterface $project,MessageRepositoryInterface $message,NotificationRepositoryInterface $notification){
        $this->project=$project;
        $this->message=$message;
        $this->notification=$notification;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=\Auth::user();
        $projectsa=$this->message->getChatProject($user->id);
        $projects=$this->project->getById($projectsa,$user->id);

        $invitedProject=$this->project->getInvitedProject(config('constants.project_talent_status.PENDING'),config('constants.project_status.PENDING'),'DESC');
        
        $activeProject=$this->project->getTalentActiveProject(config('constants.project_status.HIRED'));

        $upcommingProject=$this->project->getInvitedProject(config('constants.project_talent_status.ACCEPTED'),config('constants.project_status.PENDING'));
        $completedProject =$this->project->getInvitedProject(config('constants.project_talent_status.ACCEPTED'),config('constants.project_status.COMPLETED'));
        $disputedProject=$this->project->getInvitedProject(config('constants.project_talent_status.ACCEPTED'),config('constants.project_status.DISPUTE'));
       
       return view('web.talents.dashboard.index',compact('invitedProject','activeProject','upcommingProject','projects','completedProject','disputedProject'));
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
    public function show(Request $request,$id)
    {
        $invitedProject=$this->project->getProjectById($id);
       
        if(is_null($invitedProject)){
            return redirect()->route('talent_dashboard');
        }
        if($request->has('is_read')){
            $user=\Auth::user();
            $this->notification->readMark($user->id,$request->is_read);
        }
       
        $invitedProject->load('files');
   //  dd($invitedProject);
        return view('web.talents.dashboard.show',compact('invitedProject'));
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

    public function acceptAction(Request $request){
        try{
        $this->validate($request, [
            'project_id'=>'required|exists:projects,id',
            'no_of_days'=>'required|numeric',
            'no_of_hours'=>'required|numeric'

        ]);
        }catch(\Exception $e){
            return response()->json(['status'=>0,'message'=>$e->getMessage()]);
        }
        $currentUser=\Auth::user();
        $invitedProject=$this->project->getProjectById($request->project_id,config('constants.project_talent_status.PENDING'));
        
        
        if(!is_null( $invitedProject)){
            ProjectTalent::where('talent_user_id',$currentUser->id)->where('project_id',$request->project_id)->update([
                'status'=>config('constants.project_talent_status.ACCEPTED'),
                'no_of_days'=>$request->no_of_days,
                'no_of_hours'=>$request->no_of_hours
            ]);
             /*Notifcation code */
            
            $this->notification->create([
                'to_id'=> $invitedProject->user_id,
                'from_id'=>$currentUser->id,
                'type'=>config('notifications.notification_type.PROJECT_ACCEPTED'),
                'ref'=>$request->project_id,
                'message'=>sprintf(config('notifications.notification_message.PROJECT_ACCEPTED'),$currentUser->todz_id),
            ]);

             // sent project closed notification to remaining talents
            foreach($invitedProject->talents as $talent){
                if($talent->id!=$currentUser->id){
                    $talent_user = User::where('id', $talent->id)->first();
                    $talent_name = $talent_user->first_name.' '.$talent_user->last_name;
                    Mail::to($talent_user->email)->send(new JobClosed($talent_name));
                }
            }

            /*Notifcation code */
            $owner = User::where('id', $invitedProject->user_id)->first();
            $owner_name = $owner->first_name.' '.$owner->last_name;

            Mail::to($owner->email)->send(new JobAccepted($owner_name));

            return response()->json(['status'=>1,'message'=>"Project Invitation Accepted Successfully"]);
        }

        return response()->json(['status'=>0,'message'=>"Project not found"]);
       // return redirect()->back()->with('success',"Project Invitation accepted successfully");


    }

    public function rejectAction(Request $request){
        $this->validate($request, [
            'project_id'=>'required|exists:projects,id',
        ]);
        $currentUser=\Auth::user();
        $invitedProject=$this->project->getProjectById($request->project_id,config('constants.project_talent_status.PENDING'));
        if(!is_null( $invitedProject)){
            ProjectTalent::where('talent_user_id',$currentUser->id)->where('project_id',$request->project_id)->update([
                'status'=>config('constants.project_talent_status.REJECTED')
            ]);
             /*Notifcation code */
            
            $this->notification->create([
                'to_id'=> $invitedProject->user_id,
                'from_id'=>$currentUser->id,
                'type'=>config('notifications.notification_type.PROJECT_REJECTED'),
                'ref'=>$request->project_id,
                'message'=>sprintf(config('notifications.notification_message.PROJECT_REJECTED'),$currentUser->todz_id),
            ]);

            $owner = User::where('id', $invitedProject->user_id)->first();
            $owner_name = $owner->first_name.' '.$owner->last_name;

            Mail::to($owner->email)->send(new JobRejected($owner_name, $currentUser->todz_id));

            /*Notifcation code */
        }

        return redirect()->back()->with('success',"Project Invitation Rejected successfully");
    }

    function fetch_invited_projects(Request $request)
    {
     if($request->ajax())
     {
      $invitedProject=$this->project->getInvitedProject(config('constants.project_talent_status.PENDING'),config('constants.project_status.PENDING'),'DESC');
        $title="Job Invitations";
      return view('web.talents.dashboard.pagination_data', compact('invitedProject','title'))->render();
     }
    }

    function fetch_upcomming_project(Request $request)
    {
     if($request->ajax())
     {
        $activeProject=$this->project->getInvitedProject(config('constants.project_talent_status.ACCEPTED'),config('constants.project_status.PENDING'));
        $title="Upcoming Projects";
      return view('web.talents.dashboard.upcomming_pagination_data', compact('activeProject','title'))->render();
     }
    }
}
