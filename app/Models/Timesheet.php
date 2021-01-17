<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    protected $fillable=[
        'milestone_id',
        'description',
        'hours',
        'user_id',
        'document',
        'original_name',
        'i_c',
        'client_approved'
    ];
    protected $appends=['full_file_url'];
    public function getFullFileUrlAttribute(){
        return env('APP_URL').'/'.env('FILE_UPLOAD_PATH').'/'.$this->document;
    }
}
