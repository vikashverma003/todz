<?php namespace App\Repositories;

use App\Models\MilestoneTimeLog;
use App\Repositories\Interfaces\MilestoneTimeLogRepositoryInterface;

class MilestoneTimeLogRepository implements MilestoneTimeLogRepositoryInterface
{
    
    public function all(){
        return MilestoneTimeLog::all();
    }
    public function create(array $data){
      return MilestoneTimeLog::create([
            'milestone_id'=>$data['milestone_id'],
            'project_id'=>$data['project_id'],
            'talent_user_id'=>$data['talent_user_id'],
            'start_time'=>$data['start_time']
        ]);
    }
    public function update(array $data, $id){

    }
    public function delete($id){

    }
    public function show($id){

    }

    public function isAnyTaskRunning($project_id){
        return MilestoneTimeLog::where('project_id',$project_id)
        ->whereNull('end_time')->first();
    }
   


}