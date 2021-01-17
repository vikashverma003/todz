<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedUserCard extends Model
{
    protected $fillable=[
         'user_id',
         'mangopay_account_id',
         'is_default',
         'card_id'
       ];
}
