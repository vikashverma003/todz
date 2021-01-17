<?php 
namespace App\Repositories;

use App\Models\ProjectPayment;
use App\Repositories\Interfaces\ProjectPaymentRepositoryInterface;

class ProjectPaymentRepository implements ProjectPaymentRepositoryInterface
{
    
    public function all(){
    
    }
    public function create(array $data){
        
        return  ProjectPayment::create([
            'project_id'=>$data['project_id'],
            'to_user_id'=>$data['to_user_id'],
            'amount'=>$data['amount'],
            'coupon_discount'=>$data['coupon_discount'] ?? 0,
            'milestone_id'=>$data['milestone_id'] ?? 0,
        ]);
    }
    public function update(array $data, $id){

    }
    public function delete($id){

    }
    public function show($id){
        return ProjectPayment::where('id', $id)->first();
    }

    public function detail($id, $project_id){
        return ProjectPayment::where('id', $id)->where('project_id', $project_id)->first();
    }

    public function projectPayment($id){
      return ProjectPayment::where('project_id',$id)->get();
    }

    public function getProjectPaymentTotalRevenue(){
            return ProjectPayment::pluck('amount')->sum();
    }

}