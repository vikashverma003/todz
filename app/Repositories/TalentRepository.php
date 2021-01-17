<?php 
namespace App\Repositories;

use App\Models\Talent;
use App\Models\ProjectTalent;
use App\Repositories\Interfaces\TalentRepositoryInterface;

class TalentRepository implements TalentRepositoryInterface
{
    
    public function all(){

    }
    public function create(array $data){
        return  Talent::updateOrCreate([
            'user_id'=>$data['user_id'],
            'job_field'=>$data['job_field'],
            'job_title'=>$data['job_title'],
            'work_experience'=>$data['work_experience'],
            'available_start_date'=>$data['available_start_date'],
            'working_type'=>$data['working_type'],
            'available_end_date'=>$data['available_end_date'],
            'hours'=>$data['hours']
        ]);
    }
    public function update(array $data, $id){
        
    }
    public function delete($id){

    }
    public function show($id){

    }
    public function details($id){
        return Talent::where('user_id', $id)->first();
    }
    public function deleteByProject($project_id)
    {
        return ProjectTalent::where('project_id',$project_id)->delete();
    }

    public function profileScreening($data){
        Talent::where('user_id',$data['user_id'])->update([
            'is_profile_screened'=>$data['status'],
            'reject_reason'=>$data['reject_reason']??null
        ]);
    }
    public function aptitudeTestAttach($data){
        Talent::where('user_id',$data['user_id'])->update([
            'aptitude_test_id'=>$data['aptitude_test_id']
        ]);
    }

    public function aptitudeAction($data){
        Talent::where('user_id',$data['user_id'])->update([
            'is_aptitude_test'=>$data['status'],
            'reject_reason'=>$data['reject_reason']??null,
            'aptitude_result' => $data['aptitude_result']

        ]);
    }

    public function technicalTestAttach($data){
        Talent::where('user_id',$data['user_id'])->update([
            'technical_test_id'=>$data['technical_test_id']
        ]);
    }

    public function technicalAction($data){
        Talent::where('user_id',$data['user_id'])->update([
            'is_technical_test'=>$data['status'],
            'reject_reason'=>$data['reject_reason']??null
        ]);
    }

    public function interviewAction($data){
        Talent::where('user_id',$data['user_id'])->update([
            'is_interview'=>$data['status'],
            'reject_reason'=>$data['reject_reason']??null
        ]);
    }

    public function updatehourlyRate($user_id,$rate){
        return  Talent::where('user_id',$user_id)->update([
            'hourly_rate'=>$rate,
            'hours_approve' => config('constants.hours.PENDING')
        ]);
    }
    public function updateUserHoursApproval($user_id,$status)
    {
        return Talent::where('user_id',$user_id)->update([
            'hours_approve' => $status
        ]);
    }

}