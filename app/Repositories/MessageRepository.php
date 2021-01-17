<?php namespace App\Repositories;

use App\Models\Message;
use App\Repositories\Interfaces\MessageRepositoryInterface;

class MessageRepository implements MessageRepositoryInterface
{
    
    public function all(){
    
    }
    public function create(array $data){
      return  Message::create([
         'to_id'=>$data['to_id'],
         'from_id'=>$data['from_id'],
        'project_id'=>$data['project_id'],
        'message'=>$data['message'],
        ]);
    }
    public function update(array $data, $id){

    }
    public function delete($id){

    }
    public function show($id){

    }

    public function getUserMessage($id,$project_id){
        return Message::where('project_id',$project_id)->where(function($q) use($id){
            $q->where('to_id',$id)->orWhere('from_id',$id);
        })->get();
    }

    public function getChatProject($user_id){
       return  Message::select(\DB::raw("project_id,max(created_at) AS date"))->where(function($q) use($user_id){
            $q->where('to_id',$user_id)->orWhere('from_id',$user_id);
        })->groupBy('project_id')->orderby('date','desc')->get()->pluck('project_id')->toArray();
    }

    public function getToderWithProject($user_id){
   $tomessage=Message::select(\DB::raw("to_id as user_id,project_id,max(created_at) AS date"))->where('from_id',$user_id)->groupBy('to_id')->groupBy('project_id');
   //->pluck('user_id')->toArray();

    
     
     
     $message=Message::select(\DB::raw("from_id as user_id,project_id,max(created_at) AS date"))->where('to_id',$user_id)->
        groupBy('from_id')->groupBy('project_id')
        ->union($tomessage)->orderby('date','desc')->get();
   
  $mm=[];
  foreach($message as $value){
      if(!array_key_exists($value->id,$mm)){
         $mm[$value->user_id]=$value;
      }
      if(count($mm)>4){
      break;
      }
  }
  $mm=array_values($mm);
      return collect($mm);
    }

}