<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectTalent extends Model
{

  use SoftDeletes;
    protected $table='project_talents';

    protected $dates = ['deleted_at'];

    public function isTelentAcceptedRequest($project_id,$user_id){
     return self::where('project_id',$project_id)->where('talent_user_id',$user_id)
       ->whereIn('status',[config('constants.project_talent_status.ACCEPTED'),config('constants.project_talent_status.PENDING')])->count();
    }

    public function getProjectInfo($project_id,$user_id){
      return self::where('project_id',$project_id)->where('talent_user_id',$user_id)
      ->whereIn('status',[config('constants.project_talent_status.ACCEPTED')])->first();
    }
}
