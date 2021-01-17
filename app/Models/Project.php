<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
    protected $fillable=['user_id','title','description','duration_month','duration_day','cost','project_file','status','close_reason','todder_dispute_reason','todder_request_close_project','client_request_close_project','admin_commission','client_dispute_reason'];
    protected $dates = ['deleted_at'];
    
    public function skills()
    {
        return $this->belongsToMany('App\Models\Skill','project_skills','project_id','skill_id')->withTimestamps();
    }

    public function talent(){
        return $this->belongsTo('App\User','talent_user_id','id');
    }
    public function main_talent(){
        return $this->belongsTo('App\Models\Talent','talent_user_id','user_id');
    }

    public function project_talent(){
        return $this->belongsTo('App\Models\ProjectTalent','talent_user_id','talent_user_id')->where('status', 1)->where('project_id', $this->id);
    }

    public function payments(){
        return $this->hasMany('App\Models\ProjectPayment','project_id','id');
    }

    public function ratings(){
        return $this->hasMany('App\Models\ProjectRating','project_id','id');
    }

    public function transactions(){
        return $this->hasMany('App\Models\Transaction','project_id','id');
    }

    public function scopeFinalCost(){

        $talent=\App\Models\Talent::where('user_id', $this->talent_user_id)->first();
        $projectTalent=\App\Models\ProjectTalent::where('talent_user_id',$this->talent_user_id)->where('project_id',$this->id)->first();
        $amount = $talent->hourly_rate*$projectTalent->no_of_hours;
        return $amount;
    }
    public function talents()
    {
        return $this->belongsToMany('App\User','project_talents','project_id','talent_user_id')->withTimestamps()->withPivot('status','no_of_days','no_of_hours');
    }

    public function scopeTalentInvites($query,$user_id,$status=null)
    {
        return $query->wherehas('talents',function($q) use($user_id,$status){
            $q->where('users.id',$user_id);
            if(!is_null($status)){
                $q->where('status', $status);
            }
            
        });
    }

    public function client(){
        return $this->belongsTo('App\User','user_id','id');
    }
    
    public function isApplied(){
        $user=\Auth::user();
        $isapply=ProjectTalent::where('talent_user_id',$user->id)->where('project_id',$this->id)->first();
        if(is_null($isapply)){
            return 0;
        }
        if($isapply->status==config('constants.project_talent_status.PENDING')){
            return 0;
        }else{
            return 1;
        }
    }

    public function talentMileStone(){
        $user=\Auth::user();
        return Mileslone::where('project_id',$this->id)->where('talent_user_id',$user->id)->count();
    }

    public function clientMileStone($from_user_id){
        return Mileslone::where('project_id',$this->id)->where('talent_user_id',$from_user_id)->get();
    }

    public function messages(){
        return $this->hasMany('App\Models\Message','project_id','id');
    }

    public function files(){
        return $this->hasMany('App\Models\ProjectFile','project_id','id');
    }

    
    public function hiredTodder(){
        return $this->belongsTo('App\User','talent_user_id','id');
    }

}
