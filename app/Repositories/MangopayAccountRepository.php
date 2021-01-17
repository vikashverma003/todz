<?php 
namespace App\Repositories;

use App\Models\MangopayAccount;
use App\Repositories\Interfaces\MangopayAccountRepositoryInterface;

class MangopayAccountRepository implements MangopayAccountRepositoryInterface
{
    
    public function all(){
    
    }
    public function create(array $data){
        return  MangopayAccount::create($data);
    }

    public function update(array $data, $id){

    }
    public function delete($id){

    }
    public function show($id){

    }

    public function showUserNotification($user_id){
        return Notification::where('to_id',$user_id)->where('is_read',0)->paginate(5);
    }
    public function showUserNotificationCount($user_id){
        return Notification::where('to_id',$user_id)->where('is_read',0)->count();
    }
    public function readMark($to_id,$id){
        return Notification::where('to_id',$to_id)->where('id',$id)->update([
            'is_read'=>1
        ]);
    }
    public function showUserAllNotification($user_id){
        return Notification::where('to_id',$user_id)->orderBy('id','desc')->get();
    }
}