<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Escalation extends Model
{
    protected $fillable=['talent_id','project_id','milestone_id','owner_id','comment','status','created_at','updated_at','admin_comment','in_favour'];


    public function client(){
        return $this->belongsTo('App\User','owner_id','id');
    }
    public function talent(){
        return $this->belongsTo('App\User','talent_id','id');
    }
    public function project(){
        return $this->belongsTo('App\Models\Project','project_id','id');
    }
    public function milestone(){
        return $this->belongsTo('App\Models\Mileslone','milestone_id','id');
    }

    public function update_escl($data)
    {
        return self::where('id',$data['esclaration_id'])->update([
            'admin_comment' => $data['admin_comment']??null,
            'in_favour' => $data['in_favour'],
            'status' => config('constants.ESCLARATION_STATUS.RESOLVED')
        ]);
    }
}
