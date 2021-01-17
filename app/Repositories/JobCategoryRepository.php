<?php namespace App\Repositories;

use App\Models\JobCategory;
use App\Repositories\Interfaces\JobCategoryRepositoryInterface;

class JobCategoryRepository implements JobCategoryRepositoryInterface
{
    
    public function all(){
        return JobCategory::all();
    }
    public function create(array $data){
      
    }
    public function update(array $data, $id){

    }
    public function delete($id){

    }
    public function show($id){

    }
   


}