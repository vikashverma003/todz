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

class ProjectControllerddd extends Controller
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
        $user=Auth::guard('admin')->user();
        $data = $request->all();
        $ongoing_projects=$this->project->getAllOngoingProjects();
        $upcoming_projects = $this->project->getAllUpcomingProjects();
        $past_projects = $this->project->getAllPastProjects();
        $title= 'Projects';
        // dd($ongoing_projects,$upcoming_projects,$past_projects);
        return view('admin/project.index',compact('title','user','ongoing_projects','upcoming_projects','past_projects','data'));
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
    public function show($id)
    {
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $data = Project::where('id',$id)->firstOrFail();
        $user=Auth::guard('admin')->user();
        $payments=$this->projectPayment->projectPayment($id);
        $talent_id = $data->talents[0]->id;
        $milestones = $this->mileslone->getMileStone($id,$talent_id);
        
        return view('admin/project.detail',compact('data','user','payments','milestones'));
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
}
