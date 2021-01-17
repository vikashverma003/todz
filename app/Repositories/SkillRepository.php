<?php namespace App\Repositories;

use App\Models\Skill;
use App\Models\ProjectSkill;
use App\Repositories\Interfaces\SkillRepositoryInterface;

class SkillRepository implements SkillRepositoryInterface
{
    
    public function all(){
        return Skill::where('active',1)->get();
    }
    public function create(array $data){
      
    }
    public function update(array $data, $id){

    }
    public function delete($id){

    }
    public function show($id){

    }
    public function searchByName($keyword){
       return Skill::where('name','like',$keyword."%")->orWhere('name','like',"%".$keyword)->orWhere('name','like',"%".$keyword."%")->get();
    }
    public function deleteByProject($project_id)
    {
        return ProjectSkill::where('project_id',$project_id)->delete();
    }


}