<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



trait CommonUtil {
    public function generateTodzId(){
        return strtoupper(substr(uniqid(),0,9));
    }

    public function ValidationResponseFormating($e) {
        $errorResponse = [];
        $errors = $e->validator->errors();
        $col = new Collection($errors);
        foreach ($col as $error) {
            foreach ($error as $errorString) {
                $errorResponse[] = $errorString;
            }
        }
        return $errorResponse;
    }

    public function uploadGalery($image,$uploadPath=null){

          $name = sha1(time().time()).'.'.$image->getClientOriginalExtension();
          if(is_null($uploadPath)){
          $destinationPath = public_path(env('FILE_UPLOAD_PATH'));
          }else{
            $destinationPath = public_path($uploadPath);
        }
          $image->move($destinationPath, $name);
          return $name;

      }

      public function uploadGalery_talent($image){
          $name = sha1(time().time()).'.'.$image->getClientOriginalExtension();
          $destinationPath = public_path(env('FILE_UPLOAD_PATH'));    
          $image->move($destinationPath, $name);
          return $name;
      }

    public function printLog($lineNo,$fileName,$message,$type=1){
        Log::info("**********************".$fileName.":" .$lineNo."***********************");
        switch($type){
            case 1:
                Log::info($message);
                break;
            case 2:
                Log::error($message);
                break;
        }
        Log::info("**********************".$fileName.":" .$lineNo."***********************");
    }

    public function getAdminMangoPayAccount(){
        $user_id = \App\Admin::where('is_super', 1)->value('id');
        return \App\Models\MangopayAccount::where('user_id', $user_id)->first();
    }

    public function returnAdminUser(){
        $user_id = \App\Admin::where('is_super', 1)->value('id');
        return $user_id;
    }

    public function getAdminCommissionRate(){
        $rate = \App\Models\AdminComission::first();
        if($rate){
            return $rate->project_comission;
        }
        return 0;
    }

    // abort_unless(helperCheckPermission('order_management_access'), 403);
    function helperCheckPermission(string $permission){
        
        if(\Auth::guard('admin')->user()->is_super==1){
            return true;
        }else
        {
            $permission_id = \App\Models\Permission::where('title', $permission)->value('id');
            $permissions = \Auth::guard('admin')->user()->permissions()->pluck('permission_id')->toArray();
            if(in_array($permission_id, $permissions)){
                return true;
            }else{
                return false;
            }
        }
    }
}
