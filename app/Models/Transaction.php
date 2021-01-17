<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable=['project_id','from_user_id','payment_type','charge_from_card_id','to_user_id','amount','fees','transaction_id','response_json','coupon_discount','transaction_type'];
}
