<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talent extends Model
{
  protected $table = 'talents';
  
    protected $fillable=[
    'user_id',
    'job_field',
   'job_title',
   'work_experience',
   'available_start_date',
   'working_type',
   'available_end_date',
   'hours','hours_approve'];

   public function skills()
   {
       return $this->belongsToMany('App\Models\Skill','talent_skills','talent_id','skill_id')->withTimestamps();
   }
   public function scopeStatus($q){
    return $q->where('is_profile_screened',config('constants.test_status.APPROVED'))
    ->where('is_aptitude_test',config('constants.test_status.APPROVED'))
    ->where('is_technical_test',config('constants.test_status.APPROVED'))
    ->where('is_interview',config('constants.test_status.APPROVED'));
   }
}
