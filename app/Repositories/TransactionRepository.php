<?php 
namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use DB;

class TransactionRepository implements TransactionRepositoryInterface
{
    
    public function all(){
    }

    public function create(array $data){
      return  Transaction::create([
            'project_id'=>$data['project_id'],
            'from_user_id'=>$data['from_user_id'],
            'payment_type'=>$data['payment_type'],
            'charge_from_card_id'=>$data['charge_from_card_id'],
            'to_user_id'=>$data['to_user_id'],
            'amount'=>$data['amount'],
            'fees'=>$data['fees'],
            'transaction_id'=>$data['transaction_id'],
            'response_json'=>json_encode($data['response_json']),
            'transaction_type'=>isset($data['transaction_type']) ? $data['transaction_type']: null,
            'coupon_discount'=>isset($data['coupon_discount']) ? $data['coupon_discount']: 0,
        ]);

    }

    public function update(array $data, $id){

    }
    public function delete($id){

    }
    public function show($id){

    }
    public function getTransactionByMonthWise(){
        $transactions=Transaction::select(DB::raw("count(*) as total"),DB::raw("MONTH(created_at) as Month"))->groupBy(DB::raw("MONTH(created_at)"));
         return $transactions->get();
     }
     public function getEarningCountByMonthWise(){
        $transactions=Transaction::select(DB::raw("sum(amount) as total"),DB::raw("MONTH(created_at) as Month"))->groupBy(DB::raw("MONTH(created_at)"));
         return $transactions->get();
     }
     public function getAdminFeeCountByMonthWise(){
        $transactions=Transaction::select(DB::raw("sum(fees) as total"),DB::raw("MONTH(created_at) as Month"))->groupBy(DB::raw("MONTH(created_at)"));
         return $transactions->get();
     }

}