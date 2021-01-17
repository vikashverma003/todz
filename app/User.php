<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','email', 'password','phone_code','phone_number','account_status','role','facebook_id','linkedin_id','entity','company_name','description','no_of_employees','coupon','coupon_id','block','temp_todz_id','location','company_address','registration_number','vat_details','coupon_used','country','expected_hourly_rate','is_super','country_of_operation','country_of_origin','gst_vat_applicable','vat_gst_number','vat_gst_rate','invoice_country_code','address'
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

    protected $appends=['test_status'];

    public function talent(){
        return $this->hasOne('App\Models\Talent','user_id','id');
    }

    public function projects(){
        return $this->hasMany('App\Models\Project','user_id','id');
    }

    public function talentDoc(){
        return $this->hasMany('App\Models\TalentDocument','user_id','id');
    }
    public function scopeTestcomplete($query)
    {
        return $query->whereHas('talent',function($q){
            $q->status();
        });
    }

    public function ratings(){
        return $this->hasMany('App\Models\ProjectRating','rated_user_id','id');
    }

    public function getTestStatusAttribute(){
        $status=Self::where('id',$this->id)->whereHas('talent',function($q){
            $q->status();
        })->first();

        return is_null($status)?0:1;
    }

    public function permissions(){
        return $this->hasMany('App\Models\UserPermission','user_id','id');
    }

    public function mangopayUser(){
        return $this->hasOne('App\Models\MangopayAccount','user_id','id');
    }
    public function mangopayCard(){
        return $this->hasMany('App\Models\SavedUserCard','user_id','id');
    }
    public function attitudeTest(){
        return $this->hasMany('App\Models\TalentAptitudeTest','user_id','id');
    }
    
    public function bankAccount(){
        return $this->hasMany('App\Models\BankAccount','user_id','id');
    }

    public function bankPayout(){
        return $this->hasMany('App\Models\BankPayout','user_id','id');
    }
}
