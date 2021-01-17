<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MangopayAccount extends Model
{
    protected $fillable=['user_id','mangopay_user_id','mangopay_wallet_id','admin_id'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
