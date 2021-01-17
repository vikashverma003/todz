<?php namespace App\Repositories;

use App\Models\AppsCountry;
use App\Repositories\Interfaces\AppsCountryRepositoryInterface;

class AppsCountryRepository implements AppsCountryRepositoryInterface
{
    
    public function all(){
       return  AppsCountry::orderBy('country_name')->get();
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