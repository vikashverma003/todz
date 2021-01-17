<?php namespace App\Repositories;

use App\Models\Mileslone;
use App\Repositories\Interfaces\MilesloneRepositoryInterface;

class MilesloneRepository implements MilesloneRepositoryInterface
{
    
    public function all(){
       
    }
    public function create(array $data){
        return Mileslone::create([
                 'talent_user_id'=>$data['talent_user_id'],
                'project_id'=>$data['project_id'],
                'title'=>$data['title'],
                'description'=>$data['description'],
                'start_date'=>$data['start_date'],
               'due_date'=>$data['due_date'],
               // 'cost'=>$data['cost'],
               'no_of_hours'=>$data['no_of_hours'],
                'd_description'=>$data['d_description']??null,
                'status'=>0
        ]);
    }
    public function update(array $data, $id){

    }
    public function delete($id){
        return Mileslone::where('id',$id)->delete();
    }
    public function deleteByProject($project_id)
    {
        return Mileslone::where('project_id',$project_id)->delete();
    }
    public function show($id){
        return Mileslone::where('id',$id)->first();
    }
    public function getMileStone($project_id,$user_id){
        return Mileslone::where('project_id',$project_id)->where('talent_user_id',$user_id)->get();
    }

    public function updateStatus($data){
        $response=Mileslone::where('id',$data['id'])->update(['status' => $data['status'],
        'comment'=>$data['comment']]);
        
        return $response;
    }
    
    public function isAnyTaskRunning($project_id){
        $user=\Auth::user();
        return Mileslone::where('project_id',$project_id)->where('talent_user_id',$user->id)
        ->where('is_task_runing',1)->first();
    }

}