<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class AdminRevenue extends Model
{
    protected $fillable=['project_id','from_user_id','amount','transaction_id','transaction_response','commission_from','created_at','updated_at'];

    public function project(){
        return  $this->belongsTo('App\Models\Project','project_id','id');
    }
    public function fromUser(){
        return $this->belongsTo('App\User','from_user_id','id');
    }
    public function getTotalRevenue($year){
        if($year>1){
            return self::where(DB::raw("YEAR(created_at)"),$year)->pluck('amount')->sum();
        }
        return self::pluck('amount')->sum();
}

public function getCountforGraph($year){
    if($year>1){
       return  $project=self::select(DB::raw("sum(amount) as total"),DB::raw("MONTH(created_at) as status"))->where(DB::raw("YEAR(created_at)"),$year)->groupBy(DB::raw("MONTH(created_at)"))->get();
    }
    $project=self::select(DB::raw("sum(amount) as total"),DB::raw("YEAR(created_at) as status"))->groupBy(DB::raw("YEAR(created_at)"));
  
   return $project->get();
}
public function getRevenueYear(){
    return self::select(DB::raw("YEAR(created_at) as year"))->groupBy(DB::raw("YEAR(created_at)"))->get();
  
}
}
