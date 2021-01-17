<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectPayment extends Model
{
	use SoftDeletes;
    protected $fillable=[
		'project_id',
		'to_user_id',
		'amount',
		'coupon_discount',
		'milestone_id'
	];
     protected $dates = ['deleted_at'];
}
