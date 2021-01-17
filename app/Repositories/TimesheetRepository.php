<?php namespace App\Repositories;

use App\Models\Timesheet;
use App\Repositories\Interfaces\TimesheetRepositoryInterface;

class TimesheetRepository implements TimesheetRepositoryInterface
{
    
    public function all(){
    }

    public function create(array $data){
        return  Timesheet::create([
            'user_id'=>$data['user_id'],
            'milestone_id'=>$data['milestone_id']??null,
            'description'=>$data['description']??null,
            'hours'=>$data['hours']??0,
            'document'=>$data['file']??null,
            'original_name'=>$data['original_name']??null,
            'i_c'=>$data['i_c']??1
        ]);
    }
    
    public function update(array $data, $id){

    }
    public function delete($id){

    }
    public function show($id){

    }

    public function is_incomplete($user_id){
        return Timesheet::where('user_id',$user_id)->where('i_c',0)->first();
    }

}