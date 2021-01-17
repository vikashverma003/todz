<?php namespace App\Repositories;

use App\Models\TestResult;
use App\Repositories\Interfaces\TestResultRepositoryInterface;

class TestResultRepository implements TestResultRepositoryInterface
{
    
    public function all(){
       //return  Coupon::paginate(10);
    }
    public function create(array $data){
      return  TestResult::create([
        'user_id'=>$data['user_id'],
        'transcript_id'=>$data['transcript_id'],
        'test_name'=>$data['test_name'],
        'test_id'=>$data['test_id'],
        'percentage'=>$data['percentage'],
        'percentile'=>$data['percentile'],
        'average_score'=>$data['average_score'],
        'test_result'=>$data['test_result'],
        'Report_url'=>$data['Report_url'],
        'time'=>$data['time'],
        ]);
    }
    public function update(array $data, $id){

    }
    public function delete($id){

    }
    public function show($id){

    }
    public function getUserTest($id){
        return TestResult::where('user_id',$id)->get();
    }


}