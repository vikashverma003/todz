<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Transaction;
use App\Models\UserPermission;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Mail\NewAdminAccountMail;
use Mail;
use App\Traits\CommonUtil;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
class TransactionController extends Controller
{

    use CommonUtil;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $permissionName;
    public function __construct(UserRepositoryInterface $user,TransactionRepositoryInterface $transaction){
        $this->user=$user;
        $this->transaction=$transaction;
        $this->permissionName = 'transaction_management_access';
    }

    /**
    * return dashboard view of admin side
    */
    public function index(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $title = 'Transactions';

        $user = Auth::guard('admin')->user();
        $inputs = $request->all();
        
        $orderby = 'desc';
        if(isset($inputs['orderby'])){
            $orderby = $inputs['orderby'];
        }
        $data = Transaction::orderBy('id',$orderby)->paginate(10);

        if($request->ajax()){
            return view('admin.transactions.list',compact('data'));
        }
        $usersGraph=$this->graphState();
        $earningGraph=$this->earningState();
        return view('admin.transactions.index',compact('data','title','user','usersGraph','earningGraph'));
    }

    public function show($id){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $title = 'Transaction Details';
        $user = Auth::guard('admin')->user();
        $data = Transaction::where('id',$id)->firstOrFail();
        return view('admin.transactions.show',compact('data','title','user'));
    }

    private function graphState(){
        $grahpData=[];
        $grahpData[]=[
          'label'=>'Transaction Count',
          'data'=> [],
          'backgroundColor'=> [
            'rgba(246, 240, 104,0.2)',
           ],
          'borderColor'=> [
            'rgba(246, 240, 104,1)'
          ],
          'borderWidth'=> 2,
          
        ];
        $data=[0,0,0,0, 0, 0,0,0,0,0,0,0];
        $f= $this->transaction->getTransactionByMonthWise();
        if(sizeOf($f)>0){
            foreach($f as $v){
                $data[$v->Month-1]=(int) $v->total;
            }
        }
        $grahpData[0]['data']=$data;
        
        
        // $grahpData[]=[
        //   'label'=>'Admin Fees',
        //   'data'=> [],
        //   'backgroundColor'=> [
        //     'rgb(126, 60, 128,0.2)',
        //    ],
        //   'borderColor'=> [
        //     'rgba(126, 60, 128,1)'
        //   ],
        //   'borderWidth'=> 2
        // ];
        // $data=[0,0,0,0, 0, 0,0,0,0,0,0,0];
        // $f=$this->user->getUserByMonthWise();
        // if(sizeOf($f)>0){
        //     foreach($f as $v){
        //         $data[$v->Month-1]=(int) $v->total;
        //     }
        // }
        // $grahpData[1]['data']=$data;
        return $grahpData;
    }
    private function earningState(){
        $grahpData=[];
        $grahpData[]=[
          'label'=>'Transaction Amount Total',
          'data'=> [],
          'backgroundColor'=> [
            'rgba(45, 45, 253,0.2)',
           ],
          'borderColor'=> [
            'rgba(45, 45, 253,1)'
          ],
          'borderWidth'=> 2,
          
        ];
        $data=[0,0,0,0, 0, 0,0,0,0,0,0,0];
        $f= $this->transaction->getEarningCountByMonthWise();
        if(sizeOf($f)>0){
            foreach($f as $v){
                $data[$v->Month-1]=(int) $v->total;
            }
        }
        $grahpData[0]['data']=$data;
        
        
        $grahpData[]=[
          'label'=>'Admin Fee Total',
          'data'=> [],
          'backgroundColor'=> [
            'rgb(57, 252, 57,0.2)',
           ],
          'borderColor'=> [
            'rgba(57, 252, 57,1)'
          ],
          'borderWidth'=> 2
        ];
        $data=[0,0,0,0, 0, 0,0,0,0,0,0,0];
        $f=$this->transaction->getAdminFeeCountByMonthWise();
        if(sizeOf($f)>0){
            foreach($f as $v){
                $data[$v->Month-1]=(int) $v->total;
            }
        }
        $grahpData[1]['data']=$data;
        return $grahpData;
    }
}