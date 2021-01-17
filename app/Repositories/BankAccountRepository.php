<?php 
namespace App\Repositories;

use App\Models\BankAccount;
use App\Repositories\Interfaces\BankAccountRepositoryInterface;

class BankAccountRepository implements BankAccountRepositoryInterface
{
    
    public function all(){
    
    }
    public function create(array $data){
        return BankAccount::create($data);
    }
    public function update(array $data, $id){

    }
    public function delete($id){

    }
    public function show($id){

    }

//     public function checkCard($card_id,$user_id){
//         return  SavedUserCard::where('card_id',$card_id)
//         ->where('user_id',$user_id)
//         ->first();
//     }
// public function undefaultAllCard($user_id){
//     return  SavedUserCard::where('user_id',$user_id)
//         ->update([
//             'is_default'=>0
//         ]);
// }
// public function getDefaultCardId($user_id){
//     return SavedUserCard::where('user_id',$user_id)
//     ->where('is_default',1)
//     ->pluck('card_id')->toArray();
// }

// public function getDefaultCard($user_id){
//     return SavedUserCard::where('user_id',$user_id)
//     ->where('is_default',1)
//     ->first();
// }
  
}