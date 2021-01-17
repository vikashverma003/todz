<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email', 'password','phone_code','phone_number','is_super'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	
	public function permissions(){
       return $this->hasMany('App\Models\UserPermission','user_id','id');
    }

    public function mangopayUser(){
        return $this->hasOne('App\Models\MangopayAccount','admin_id','id');
    }
    public function bankAccount(){
        return $this->hasMany('App\Models\BankAccount','admin_id','id');
    }
    public function bankPayout(){
        return $this->hasMany('App\Models\BankPayout','admin_id','id');
    }
}