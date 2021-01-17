<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminComission extends Model
{
	protected $table = 'admin_comission';
    
    public function createComission($project_comission, $payment_gateway_fee, $vat,$vat_number){
    	return self::insert([
    		'project_comission' => $project_comission,
            'payment_gateway_fee' => $payment_gateway_fee,
            'vat' => $vat,
            'vat_number' => $vat_number,
    	]);
    }
    
    public function updateComission($id,$project_comission, $payment_gateway_fee, $vat,$vat_number){
    	return self::where('id',$id)->update([
    		'project_comission' => $project_comission,
            'payment_gateway_fee' => $payment_gateway_fee,
            'vat' => $vat,
            'vat_number' => $vat_number,
    	]);
    }
    
    public function getComission(){
    	return self::first();
    }
}
