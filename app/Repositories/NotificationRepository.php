<?php namespace App\Repositories;

use App\Models\Notification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;

class NotificationRepository implements NotificationRepositoryInterface
{
    
    public function all(){
    
    }
    public function create(array $data){
      return  Notification::create([
         'to_id'=>$data['to_id'],
         'from_id'=>$data['from_id'],
        'type'=>$data['type'],
        'ref'=>$data['ref'],
        'message'=>$data['message'],
        ]);
    }
    public function update(array $data, $id){

    }
    public function delete($id){

    }
    public function show($id){

    }

    public function showUserNotification($user_id){
        return Notification::where('to_id',$user_id)->where('is_read',0)->orderBy('id','desc')->paginate(5);
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