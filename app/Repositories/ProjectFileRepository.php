<?php namespace App\Repositories;

use App\Models\ProjectFile;
use App\Repositories\Interfaces\ProjectFileRepositoryInterface;
use Auth;
class ProjectFileRepository implements ProjectFileRepositoryInterface
{
    
    public function all(){

    }
    public function create(array $data){
        return ProjectFile::create([
            'project_id'=>$data['project_id'],
            'file_name'=> $data['file_name'],
            'original_name'=>$data['original_name']
        ]);
    }
    public function update(array $data, $id){

    }
    public function delete($id){
        
    }

 public function show($id){

    }

    public function deleteProjectFiles($project_id){
        return ProjectFile::where('project_id',$project_id)->delete();
    }
   
  public function findImageByOriginalName($name,$project_id){
    return ProjectFile::where('original_name',$name)->where('project_id',$project_id)->first();
  }

}
