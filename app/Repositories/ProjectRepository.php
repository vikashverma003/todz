<?php 
namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Auth;
use App\Models\Mileslone;
use App\Models\ProjectPayment;
use App\Models\ProjectTalent;
use App\Models\Talent;
use App\Models\ProjectRating;
use \Carbon\Carbon;
use DB;
use App\User;

class ProjectRepository implements ProjectRepositoryInterface
{
    
    public function all(){

    }
    public function create(array $data){
        return Project::updateOrCreate([
            'user_id'=>$data['user_id'],
            'status'=>config('constants.project_status.IN-COMPLETE')
        ],[
            'user_id'=>$data['user_id'],
            'title'=>$data['title']??'',
            'description'=>$data['description']??'',
            'duration_month'=>$data['duration_month']??0,
            'duration_day'=>$data['duration_day']??0,
            'cost'=>$data['cost']??0,
            'project_file'=>$data['project_file']??null,
            'status'=>config('constants.project_status.IN-COMPLETE')
        ]);
    }
    public function update(array $data, $id){

    }
    public function delete($id){

    }
    public function show($id){
        $user=Auth::user();
       return  Project::where('id',$id)->where('user_id',$user->id)->first();
    }
    public function details($id){
       return  Project::where('id',$id)->first();
    }

    public function getIncompleteProject(){
       return Project::where('status',config('constants.project_status.IN-COMPLETE'))->first();
    }

    public function getLatestIncompleteProject($user_id){
        return Project::where('user_id', $user_id)->where('status',config('constants.project_status.IN-COMPLETE'))->orderBy('id','desc')->first();
    }

    public function deleteIncompleteProjects($user_id){
        // return Project::where('user_id', $user_id)->where('status',config('constants.project_status.IN-COMPLETE'))->where('created_at', '<', Carbon::now()->subDays(1))->delete();
        return Project::where('user_id', $user_id)->where('status',config('constants.project_status.IN-COMPLETE'))->delete();
    }

    public function getOwnProject($perPage=5){
        $user=Auth::user();
        return Project::where('user_id',$user->id)->whereIn('status',[config('constants.project_status.PENDING'),config('constants.project_status.IN-COMPLETE')])->with(['talents'=>function($q){
            $q->whereIn('status',[config('constants.project_talent_status.ACCEPTED'),config('constants.project_talent_status.PENDING')]);
        }])->orderBy('id','desc')->paginate($perPage);
    }

    // get only posted projects for client dashboard
    public function getPostedProject($perPage=5){
        $user=Auth::user();
        return Project::where('user_id',$user->id)->whereIn('status',[config('constants.project_status.PENDING')])->with(['talents'=>function($q){
            $q->whereIn('status',[config('constants.project_talent_status.PENDING')]);
        }])->whereHas('talents', function($q){
            $q->whereIn('status',[config('constants.project_talent_status.PENDING')]);
        })->orderBy('id','desc')->paginate($perPage);
    }

    // get upcoming project of client to client dashboard
    public function getUpcomingProject($perPage=10){
        $user = Auth::user();
        return Project::where('user_id',$user->id)->whereIn('status',[config('constants.project_status.PENDING')])->with(['talents'=>function($q){
            $q->whereIn('status',[config('constants.project_talent_status.ACCEPTED')]);
        }])->whereHas('talents', function($q){
            $q->whereIn('status',[config('constants.project_talent_status.ACCEPTED')]);
        })->orderBy('id','desc')->paginate($perPage);
    }

    // get active project of client in which talent is hired
    public function getActiveProject($perPage=5){
        $user=Auth::user();
        return Project::where('user_id',$user->id)->where('status',config('constants.project_status.HIRED'))->with(['talents'=>function($q){
            $q->whereIn('status',[config('constants.project_talent_status.ACCEPTED'),config('constants.project_talent_status.PENDING')]); 
        }])->orderBy('id','desc')->paginate($perPage);
    }

    public function getInvitedProject($status,$projectStatus,$orderBy='ASC',$perPage=5){
        $user=Auth::user();
        return Project::talentInvites($user->id,$status)->where('status',$projectStatus)->orderBy('id',$orderBy)->paginate($perPage);
    }
    public function getTalentActiveProject($projectStatus,$orderBy='ASC',$perPage=5){
        $user=Auth::user();
        return Project::where('status',$projectStatus)->where('talent_user_id', $user->id)->orderBy('id',$orderBy)->paginate($perPage);
    }

    public function getProjectById($id,$status=null){
        $user=Auth::user();
        return Project::where('id',$id)->talentInvites($user->id,$status)->first();
    }
    

    public function getById($ids,$user_id){
       $abc=Project::whereIn('id',$ids)->with(['messages'=>function($q) use($user_id){
            $q->where('to_id',$user_id)->orWhere('from_id',$user_id)->orderBy('created_at','desc')->limit(1);
        }]);
        if(count($ids)>0){
            $abc->orderByRaw("field(id,".implode(',',$ids).")");
        }
        return   $abc->get();
    }

    public function find($id,$user_id){
        return Project::where('id',$id)->with(['messages'=>function($q) use($user_id){
            $q->where('to_id',$user_id)->orWhere('from_id',$user_id)->orderBy('created_at','desc')->limit(1);
        }])->first();
    }

    public function hireTodder($user_id,$project_id,$todder_user_id){
        return Project::where('user_id',$user_id)->where('id',$project_id)->update([
            'talent_user_id'=>$todder_user_id,
            'status'=>config('constants.project_status.HIRED')
        ]);
    }

  public function isTodderHired($project_id,$todder_user_id=null){
     $count=Project::where('id',$project_id);
    if(!is_null($todder_user_id)){
        $count->where('talent_user_id',$todder_user_id);
    }
   
    return  $count->where('status',config('constants.project_status.HIRED'))->count();
  }
  public function countProject($status){
    $user=Auth::user();
    return Project::talentInvites($user->id,$status)->count();
}


    public function isReleasePayment($milestone_id){
        $m=Mileslone::where('id',$milestone_id)->first();
        $project=Project::where('id',$m->project_id)->first();
        $milestone=Mileslone::where('talent_user_id',$project->talent_user_id)
        ->where('project_id',$m->project_id)->where('status',config('constants.milestone_status.APPROVED'))->pluck('no_of_hours')->toArray();

        $projectTalent=ProjectTalent::where('talent_user_id',$project->talent_user_id)
        ->where('project_id',$m->project_id)->first();
        $completedTotal=array_sum( $milestone);
// dd($completedTotal);
        $paidAmt=ProjectPayment::where('to_user_id',$project->talent_user_id)
        ->where('project_id',$m->project_id)->pluck('amount')->toArray();
        $paidAmount=array_sum(  $paidAmt);
       $talent= Talent::where('user_id',$project->talent_user_id)->first();

       $totalProjectCost=$projectTalent->no_of_hours*$talent->hourly_rate;

        if($projectTalent->no_of_days<=30){
            
            if($completedTotal>=(int)$projectTalent->no_of_hours){
                if($paidAmount<$totalProjectCost){
                    $remainingAmount= $totalProjectCost-$paidAmount;
                    return ['project'=>$project,'amount'=> $remainingAmount];
                }
            }else if($completedTotal>=$projectTalent->no_of_hours){
                if($paidAmount<$totalProjectCost){
                    $remainingAmount= $totalProjectCost-$paidAmount;
                    return ['project'=>$project,'amount'=> $remainingAmount];
                }
                
            }
            
        }else{

            if($completedTotal>=(int)$projectTalent->no_of_hours){
                if($paidAmount<$totalProjectCost){
                    $remainingAmount= $totalProjectCost-$paidAmount;
                    return ['project'=>$project,'amount'=> $remainingAmount];
                }
            }else if($completedTotal>=$projectTalent->no_of_hours/2){
                if($paidAmount<$totalProjectCost/2){
                    $remainingAmount= $totalProjectCost/2-$paidAmount;
                    return ['project'=>$project,'amount'=> $remainingAmount];
                }
                
            }else if($completedTotal>=$projectTalent->no_of_hours/4){
                if($paidAmount<$totalProjectCost/4){
                    $remainingAmount= $totalProjectCost/4-$paidAmount;
                    return ['project'=>$project,'amount'=> $remainingAmount];
                }

        }
        return ['project'=>$project,'amount'=>0];
    }
}
    public function getAllOngoingProjects($perPage=10)
    {
         return Project::whereIn('status',[config('constants.project_status.ACTIVE'),config('constants.project_status.HIRED')])->paginate($perPage);
    }
    public function getAllUpcomingProjects($perPage=10)
    {
         return Project::whereIn('status',[config('constants.project_status.PENDING')])->paginate($perPage);
    }
    public function getAllPastProjects($perPage=10)
    {
         return Project::whereIn('status',[config('constants.project_status.COMPLETED'),config('constants.project_status.IN-COMPLETE')])->paginate($perPage);
    }

    // set project payment flag to 1 if project duration is less than 30 days.
    public function paymentChargeFlag($user_id,$project_id,$is_full_charge){
        return Project::where('user_id',$user_id)->where('id',$project_id)->update([
          'is_full_payment_escrow'=>$is_full_charge
        ]);
    }

    // check if client paid all milestones payment
    public function checkProjectAllPaymentsRelease($project_id){
        $project=Project::where('id',$project_id)->first();

        $milestone=Mileslone::where('talent_user_id',$project->talent_user_id)
                            ->where('project_id',$project_id)
                            ->where('status',config('constants.milestone_status.APPROVED'))
                            ->pluck('no_of_hours')->toArray();

        $projectTalent=ProjectTalent::where('talent_user_id',$project->talent_user_id)
                                    ->where('project_id',$project_id)->first();

        $completedTotal=array_sum($milestone);

        $paidAmt=ProjectPayment::where('to_user_id',$project->talent_user_id)->where('project_id',$project_id)->pluck('amount')->toArray();

        // total amount paid till now by client
        $paidAmount = array_sum($paidAmt);
        $talent = Talent::where('user_id',$project->talent_user_id)->first();

        $totalProjectCost=$projectTalent->no_of_hours*$talent->hourly_rate;
        $remainingAmount = 0;
        // check if duration is less than 30 days.
        if($projectTalent->no_of_days<=30)
        {
            if($completedTotal>=(int)$projectTalent->no_of_hours){
                if($paidAmount<$totalProjectCost){
                    $remainingAmount = $totalProjectCost-$paidAmount;
                }
            }else if($completedTotal>=$projectTalent->no_of_hours/2){
                if($paidAmount<$totalProjectCost/2){
                    $remainingAmount= $totalProjectCost/2-$paidAmount;
                }
            }
        }else
        {
            if($completedTotal>=(int)$projectTalent->no_of_hours){
                if($paidAmount<$totalProjectCost){
                    $remainingAmount= $totalProjectCost-$paidAmount;
                   
                }
            }else if($completedTotal>=$projectTalent->no_of_hours/2){
                if($paidAmount<$totalProjectCost/2){
                    $remainingAmount= $totalProjectCost/2-$paidAmount;
                }
                
            }else if($completedTotal>=$projectTalent->no_of_hours/4){
                if($paidAmount<$totalProjectCost/4){
                    $remainingAmount= $totalProjectCost/4-$paidAmount;
                }
            }
        }
        return $remainingAmount;
    }

    /**
    * get disputed projects for particular client
    **/
    public function getclientDisputedProjects($perPage=5){
        $user=Auth::user();
        return Project::where('user_id',$user->id)->where('status', config('constants.project_status.DISPUTE'))->orderBy('id','desc')->paginate($perPage);
    }

    /**
    * get disputed projects which marked close by client or talent
    **/
    public function getAllDisputedProjects($perPage=10){
        return Project::where('status', config('constants.project_status.DISPUTE'))->orderBy('id','desc')->paginate($perPage);
    }

    /**
    * get completed projects of particular client
    **/
    public function getclientCompletedProjects($perPage=10){
        $user=Auth::user();
        return Project::where('user_id',$user->id)->where('status', config('constants.project_status.COMPLETED'))->orderBy('id','desc')->paginate($perPage);
    }

    // give rating to project after completion
    public function giveProjectRating($data){
        return ProjectRating::updateOrCreate([
                'project_id'=>$data['project_id'],
                'given_by_user_id'=>$data['given_by_user_id'],
                'rated_user_id'=>$data['rated_user_id'],
            ],[
            'project_id'=>$data['project_id'],
            'given_by_user_id'=>$data['given_by_user_id'],
            'rated_user_id'=>$data['rated_user_id'],
            'rating'=>$data['rating'],
            'feedback'=>$data['feedback'],
            'rating_given_by'=>$data['rating_given_by'],
        ]);
    }
    public function getTotalProjectPosted($isShow){
        $project=Project::whereNotIn('status',[config('constants.project_status.IN-COMPLETE')]);
        if($isShow==2){
            $project=$project->where(DB::raw("MONTH(created_at)"), DB::raw("MONTH(CURRENT_DATE())"))->
            groupBy(DB::raw("MONTH(created_at)"));
         }else if($isShow==3){
             $project=$project->where(DB::raw("YEAR(created_at)"), DB::raw("YEAR(CURRENT_DATE())"))->groupBy(DB::raw("YEAR(created_at)")); 
         }
        return $project->count();
    }

    public function getProjectCountByStatus($isShow){
         $project=Project::select(DB::raw("count(*) as total"),'status')->whereNotIn('status',[config('constants.project_status.IN-COMPLETE')])->groupBy('status');
        if($isShow==2){
           $project=$project->where(DB::raw("MONTH(created_at)"), DB::raw("MONTH(CURRENT_DATE())"))->
           groupBy(DB::raw("MONTH(created_at)"));
        }else if($isShow==3){
            $project=$project->where(DB::raw("YEAR(created_at)"), DB::raw("YEAR(CURRENT_DATE())"))->groupBy(DB::raw("YEAR(created_at)")); 
        }
        return $project->get();
    }
    public function returnClientInvoicePdf($project, $payment, $admincomission){
        set_time_limit(300);

        $logedInuser = Auth::user();
        $projectTalent = ProjectTalent::where('talent_user_id',$project->talent_user_id)->where('project_id',$project->id)->first();
        $talent= Talent::where('user_id',$project->talent_user_id)->first();
        $talentUser = User::where('id', $project->talent_user_id)->first();
        
        $talentUserGst = 0;
        $clientUserGstNumber = 'Not Applicable';
        if($logedInuser->gst_vat_applicable=='yes'){
            $clientUserGstNumber = $logedInuser->vat_gst_number;
        }

        $countriesCode = config('constants.invoice_country_codes');
        $europeCountries = config('constants.europe_countries');
        
        // as per document add 20% VAT for Estonia client
        if($logedInuser->invoice_country_code=='Estonia'){
            $talentUserGst = 20;
        }
        elseif ($logedInuser->gst_vat_applicable=='yes') {
            $talentUserGst = 0;
        }
        elseif ($logedInuser->gst_vat_applicable=='no' && in_array($logedInuser->invoice_country_code, $europeCountries)) {
            $talentUserGst = 20;
        }
        else{
            if($talentUser->gst_vat_applicable=='yes'){
                $talentUserGst = $talentUser->vat_gst_rate;
            }
        }
        $milestone = Mileslone::where('id', $payment->milestone_id)->first(); 
        $project_duration = 0;
        if($milestone){
            $project_duration = $milestone->no_of_hours;
        }
        $projectStatus = 'In-Progress';
        if($projectTalent->no_of_days<=30){
            $projectStatus = '100%';
        }else{
            if($milestone){
                $prevPayments = ProjectPayment::where('project_id',$project->id)->where('id','<',$payment->id)->count();
                if($prevPayments==0){
                    $projectStatus = '25%';
                }
                elseif($prevPayments==1){
                    $projectStatus = '50%';
                }elseif ($prevPayments==2) {
                    $projectStatus = '100%';
                }
                elseif ($prevPayments==3) {
                    $projectStatus = '100%';
                }else{
                    $projectStatus = 'In-Progress';
                }
            }
        }
        
        $address = explode(',', $logedInuser->address);

        $pdf = \PDF::loadView('pdfTemplate.client-invoice', compact('project','payment','logedInuser','projectTalent','talent','admincomission','projectStatus','talentUser','talentUserGst','clientUserGstNumber','address','project_duration'));
        return $pdf;
    }

    public function returnTalentInvoicePdf($talentUser,$project, $payment, $admincomission){
        set_time_limit(300);

        $todder = $talentUser;
        $milestone = Mileslone::where('id', $payment->milestone_id)->first(); 
        $project_duration = 0;
        if($milestone){
            $project_duration = $milestone->no_of_hours;
        }

        $projectStatus = 'In-Progress';
        $projectTalent = ProjectTalent::where('talent_user_id',$project->talent_user_id)->where('project_id',$project->id)->first();
        if($projectTalent->no_of_days<=30){
            $projectStatus = '100%';
        }
        else{
            if($milestone){
                $prevPayments = ProjectPayment::where('project_id',$project->id)->where('id','<',$payment->id)->count();
                if($prevPayments==0){
                    $projectStatus = '25%';
                }
                elseif($prevPayments==1){
                    $projectStatus = '50%';
                }elseif ($prevPayments==2) {
                    $projectStatus = '100%';
                }
                elseif ($prevPayments==3) {
                    $projectStatus = '100%';
                }else{
                    $projectStatus = 'In-Progress';
                }
            }
        }
        $talent = Talent::where('user_id',$project->talent_user_id)->first();
        
        $talentUserGst = 0;
        $talentUserGstNumber = 'Not Applicable';
        if($todder->gst_vat_applicable=='yes'){
            $talentUserGst = $todder->vat_gst_rate;
            $talentUserGstNumber = $todder->vat_gst_number;
        }
        $address = explode(',', $todder->address);

        $pdf = \PDF::loadView('pdfTemplate.todder-invoice', compact('project','payment','todder','admincomission','projectStatus','projectTalent','talent','talentUserGst','talentUserGstNumber','address','project_duration'));
        
        return $pdf;
    }
}