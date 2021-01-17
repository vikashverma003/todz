<?php
namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait NotificationManager {
    public function createNotification($object,$data){
       	return  $object->create([
			'to_id'=>$data['to_id'],
			'from_id'=>$data['from_id'],
			'type'=>$data['type'],
			'ref'=>$data['ref'],
			'message'=>$data['message'],
        ]);
    }
}