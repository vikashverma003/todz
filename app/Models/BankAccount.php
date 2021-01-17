<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable=[
        'user_id',
        'mangopay_account_id',
        'is_default',
        'bank_id',
        'response',
        'admin_id'
      ];
}
