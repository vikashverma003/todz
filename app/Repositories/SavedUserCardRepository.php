<?php namespace App\Repositories;

use App\Models\SavedUserCard;
use App\Repositories\Interfaces\SavedUserCardRepositoryInterface;

class SavedUserCardRepository implements SavedUserCardRepositoryInterface
{
    
    public function all(){
    
    }
    public function create(array $data){
      return  SavedUserCard::create([
         'user_id'=>$data['user_id'],
         'mangopay_account_id'=>$data['mangopay_account_id'],
        'is_default'=>$data['is_default'],
        'card_id'=>$data['card_id']
        ]);
    }
    public function update(array $data, $id){

    }
    public function delete($id){

    }
    public function show($id){

    }

    public function checkCard($card_id,$user_id){
        return  SavedUserCard::where('card_id',$card_id)
        ->where('user_id',$user_id)
        ->first();
    }
public function undefaultAllCard($user_id){
    return  SavedUserCard::where('user_id',$user_id)
        ->update([
            'is_default'=>0
        ]);
}
public function getDefaultCardId($user_id){
    return SavedUserCard::where('user_id',$user_id)
    ->where('is_default',1)
    ->pluck('card_id')->toArray();
}

public function getDefaultCard($user_id){
    return SavedUserCard::where('user_id',$user_id)
    ->where('is_default',1)
    ->first();
}
  
}