<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\Interfaces\MilesloneRepositoryInterface;
use App\Repositories\Interfaces\SkillRepositoryInterface;
use App\Repositories\Interfaces\TalentRepositoryInterface;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Mileslone;
use App\Repositories\Interfaces\ProjectPaymentRepositoryInterface;
use PDF;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Admin;

class ProjectController extends Controller
{
    use \App\Traits\CommonUtil;

    public $permissionName;
    public function __construct(ProjectRepositoryInterface $project, MilesloneRepositoryInterface $mileslone,SkillRepositoryInterface $skill,TalentRepositoryInterface $talent, ProjectPaymentRepositoryInterface $projectPayment, UserRepositoryInterface $user){
        $this->project=$project;
        $this->mileslone = $mileslone;
        $this->skill = $skill;
        $this->talent = $talent;
        $this->projectPayment=$projectPayment;
        $this->user=$user;
        $this->permissionName = 'projects_management_access';
    }


    public function index(Request $request)
    {
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $title = 'Projects';
        $user=Auth::guard('admin')->user();
        $data = $request->all();
        $inputs = $request->all();
        
        $users = Admin::where('is_super', 0);
      
        $project=Project::whereNotIn('status',[config('constants.project_status.IN-COMPLETE')]);
        $project = self::filters($project, $inputs, $request);
        $orderby = 'desc';
        if(isset($inputs['orderby'])){
            $orderby = $inputs['orderby'];
        }
        $projects = $project->orderBy('id',$orderby)->paginate(10);
        if($request->ajax()){
            return view('admin.project.list',compact('projects'));
        }
        $allSkills=$this->skill->all();
        return view('admin.project.index1',compact('title','user','projects','allSkills'));
   
    }

    /**
    * get disputed projects
    **/
    public function getDisputedProjects(){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $user=Auth::guard('admin')->user();
        $projects = $this->project->getAllDisputedProjects();
        $title= 'Disputed Projects';
        
        return view('admin/disputed-projects.index',compact('title','user','projects'));
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
    public function show(Request $request, $id)
    {
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        if($request->ajax()){
            $id = $request->id;
        }

        $data = Project::where('id',$id)->with(['client','talents','transactions'])->firstOrFail();
        $user=Auth::guard('admin')->user();
        $payments=$this->projectPayment->projectPayment($id);
        $talent_id = $data->talents[0]->id;

        $milestones = $this->mileslone->getMileStone($id,$talent_id);
        $project_talent = \App\Models\ProjectTalent::where('talent_user_id', $data->talent_user_id)->where('status',1)->where('project_id', $id)->first();
        $hourlyRate = isset($data->talents[0]->hourly_rate) ? $data->talents[0]->hourly_rate : 0;

        $spend_hours = 0;
        $milestonesData = \App\Models\Mileslone::where('project_id',$id)->where('talent_user_id',$data->talent_user_id)->with(['timesheet'])->get();
        foreach ($milestonesData as $key => $value) {
            $spend_hours+=$value->timesheet->sum('hours');
        }

        $projects = Project::whereNotIn('status',[config('constants.project_status.IN-COMPLETE')])->orderby('id','desc')->select('id','title')->get();
        if($request->ajax()){
            return view('admin/project.detail',compact('data','user','payments','milestones','project_talent','hourlyRate','talent_id','spend_hours','projects'));
        }
        return view('admin/project.detail',compact('data','user','payments','milestones','project_talent','hourlyRate','talent_id','spend_hours','projects'));
    }

    public function milestoneInvoice($project_id, $project_payment_id){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $project = Project::where('id',$project_id)->firstOrFail();
        $payment = $this->projectPayment->detail($project_payment_id, $project_id);
        if(!$payment){
            return redirect('404');
        }
        $pdf = PDF::loadView('pdfTemplate.milestone-invoice', compact('project','payment'));
        return $pdf->stream('invoice.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd($id);
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
    public function destroy(Request $request,$id)
    {
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $this->mileslone->deleteByProject($id);
        $this->skill->deleteByProject($id);
        $this->talent->deleteByProject($id);
        $this->project->deleteProject($id);
        return redirect('admin/projects?page='.$request->page)->with('success','Project Deleted successfully') ;
    }

    private function filters($users, $inputs, $request){
     
        if(isset($inputs['client_name']) && !empty($inputs['client_name'])){
            $users->whereHas('client',function($q) use ($inputs){
                $q->where('first_name', 'like', '%' . $inputs['client_name'] . '%')->orWhere('last_name', 'like', '%' . $inputs['client_name'] . '%');
            });
         }
     
         if(isset($inputs['skill']) && !empty($inputs['skill'])){
             $users->whereHas('skills',function($q) use($inputs){
                $q->where('skills.id',$inputs['skill']);
             });
         }
         if(isset($inputs['title']) && !empty($inputs['title'])){
            $users->where('title', 'like', '%' . $inputs['title'] . '%');
         }
       
        if(isset($inputs['status'])&& !empty($inputs['status'])){
            $users->where('status',$inputs['status']);
        }
       
        if($request->filled('start') && $request->filled('end'))
        {
            $date1 = str_replace('/', '-', $request->start);
            $date1 = date('Y-m-d', strtotime($date1));
            $date2 = str_replace('/', '-', $request->end);
            $date2 = date('Y-m-d', strtotime($date2));
            
            $users->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2);
        }
        elseif ($request->filled('start')) {
            $date = str_replace('/', '-', $request->start);
            $date = date('Y-m-d', strtotime($date));
            $users->whereDate('created_at','>=' ,$date);
        }
        elseif($request->filled('end')){
            $date = str_replace('/', '-', $request->end);
            $date = date('Y-m-d', strtotime($date));
            $users->whereDate('created_at','<=' ,$date);
        }else{}

        return $users;
    }
    public function export(Request $request){
        return (new \App\Exports\ProjectExport)->download('projects.xlsx');
    }  

}
