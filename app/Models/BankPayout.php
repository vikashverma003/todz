<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankPayout extends Model
{
    protected $fillable=[
        'user_id',
        'bank_account_id',
        'payout_id',
        'response',
        'amount',
        'status',
        'admin_id'
    ];
    
    public function createBankPayout($data){
        return self::create([
            'user_id'=>$data['user_id'],
            'bank_account_id'=>$data['bank_account_id'],
            'payout_id'=>$data['payout_id'],
            'response'=>$data['response'],
            'amount'=>$data['amount'],
            'status'=>$data['status']
        ]);
    }

    public function bankAccount(){
        return $this->belongsTo('App\Models\BankAccount','bank_account_id','id');
    }
}
