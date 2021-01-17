<?php
namespace App\Helpers;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use App\Repositories\MilesloneRepository;
use Auth;
use App\Models\ProjectTalent;
class ProjectManager {
    
    public function __construct(){
        $this->project=new ProjectRepository();
        $this->user=new UserRepository();
        $this->mileStone=new MilesloneRepository();
    }
    
    public function isTodderHired($project_id,$todder_id){
        if($this->project->isTodderHired($project_id,$todder_id)==0){
            if($this->project->isTodderHired($project_id)>0){
                return 2;
            }else{
                return 0;
            }
        }else{
            return 1;
        }
    }

    public function userCount($role){
       return  $this->user->countByRole($role);
    }
    public function getRuningHours($sumTime){
    $hours = $sumTime / 3600;
    $minutes = ($sumTime % 3600) / 60;

    return  sprintf("%d Hrs %d Mins", $hours, $minutes); 
    }
    public function isTaskRunning($project_id){
        $milestone=$this->mileStone->isAnyTaskRunning($project_id);
        return is_null( $milestone)?false:true;
    }

    public function getRuningSe($project_id){
        $milestone=$this->mileStone->isAnyTaskRunning($project_id);
        $totalSec=(time()-$milestone->tracker_start_time)+$milestone->runing_time;
        return $totalSec;
    }

    public function projectTotalPrice($project_id,$talent_user_id){
        $talent=$this->user->getUserById($talent_user_id);
        
        $projectTalent=ProjectTalent::where('talent_user_id',$talent_user_id)->where('project_id',$project_id)->first();
        return  $talent->talent->hourly_rate*$projectTalent->no_of_hours;
    }

    public function projectTotalPriceForClient($project_id,$talent_user_id){
        $talent=$this->user->getUserById($talent_user_id);
        
        $projectTalent=ProjectTalent::where('talent_user_id',$talent_user_id)->where('project_id',$project_id)->first();
        $amount = $talent->talent->hourly_rate*$projectTalent->no_of_hours;

        $rateF = \App\Models\AdminComission::first();
        $rate = $rateF->project_comission;
        return $amount + ($rate/100*$amount);
        
    }

    public function getProjectDuration($project_id,$talent_user_id){
        
        $talent=$this->user->getUserById($talent_user_id);
        $projectTalent=ProjectTalent::where('talent_user_id',$talent_user_id)->where('project_id',$project_id)->first();
        return $projectTalent->no_of_days;
    }
}
