<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    
    protected $fillable=[
        'user_id',
        'transcript_id',
        'test_name',
        'test_id',
        'percentage',
        'percentile',
        'average_score',
        'test_result',
        'Report_url',
        'time'
    ];
}
