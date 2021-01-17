<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mileslone extends Model
{
    use SoftDeletes;
    
    protected $fillable=[
        'talent_user_id',
        'project_id',
        'title',
        'description',
        'start_date',
        'due_date',
        // 'cost',
        'no_of_hours',
        'd_description',
        'status'
    ];
    protected $dates = ['deleted_at'];

    public function timesheet(){
        return $this->hasMany('App\Models\Timesheet','milestone_id','id');
    }
}
