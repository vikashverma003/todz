<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MilestoneTimeLog extends Model
{
    protected $fillable=[
       'milestone_id',
       'project_id',
       'talent_user_id',
       'start_time'
    ];
}
