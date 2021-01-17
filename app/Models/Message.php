<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable=[
        'to_id',
        'from_id',
       'project_id',
       'message',
    ];

    public function project(){
        return $this->belongsTo('App\Models\Project','project_id','id');
    }
    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
    
    public function messageDetail(){
       
        $user_id=$this->user_id;
       return  self::where('project_id',$this->project_id)->where(function($q) use($user_id){
            $q->where('to_id',$user_id)->orWhere('from_id',$user_id);
        })->orderBy('created_at','desc')->first();
    }
}
