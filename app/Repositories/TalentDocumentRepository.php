<?php namespace App\Repositories;

use App\Models\TalentDocument;
use App\Repositories\Interfaces\TalentDocumentRepositoryInterface;
use Auth;
class TalentDocumentRepository implements TalentDocumentRepositoryInterface
{
    
    public function all(){

    }
    public function create(array $data){
        return TalentDocument::create([
            'user_id'=>$data['user_id'],
            'file_name'=> $data['file_name'],
            'original_name'=>$data['original_name'],
            'type'=>$data['type']
        ]);
    }
    public function update(array $data, $id){

    }
    public function delete($id){
        
    }

 public function show($id){

    }

    public function deleteProjectFiles($user_id){
        return TalentDocument::where('user_id',$user_id)->delete();
    }
   
  public function findImageByOriginalName($name,$user_id){
    return TalentDocument::where('original_name',$name)->where('user_id',$user_id)->first();
  }

}
