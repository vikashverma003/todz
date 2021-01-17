<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable=['name','code','description','max_redemption','expire_date','price','discount_type','coupon_type','coupon_value'];
}
