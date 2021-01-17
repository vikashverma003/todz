<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\AdminRevenue;
use App\Models\UserPermission;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Mail\NewAdminAccountMail;
use Mail;
use App\Traits\CommonUtil;
use App\Models\MangopayAccount;

class WalletController extends Controller
{

    use CommonUtil;
    use \App\Traits\MangoPayManager;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $permissionName;
    public function __construct(){
        $this->permissionName = 'revenue_management_access';
    }

    /**
    * return dashboard view of admin side
    */
    public function index(Request $request){
     //   abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $title = 'Wallet';

        $user = Auth::guard('admin')->user();
        $inputs = $request->all();      
        $orderby = 'desc';
        if(isset($inputs['orderby'])){
            $orderby = $inputs['orderby'];
        }
        $mangopay=MangopayAccount::query();
      //  $adminRevenue = self::filters($adminRevenue, $inputs, $request);

        $data = $mangopay->where('user_id','<>',0)->orderBy('id',$orderby)->paginate(10);
        $token=$this->token();  
        foreach($data as $key=>$value){
            $walletInfo=$this->veiwWallet( $token->access_token,$value->mangopay_wallet_id);
           // dd($walletInfo);
             $data[$key]->walletInfo=$walletInfo;
        }

        // dd($data);

        if($request->ajax()){
            return view('admin.wallet-balance.list',compact('data'));
        }
        return view('admin.wallet-balance.index',compact('data','title','user'));
    }

    public function show($id){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $title = 'Transaction Details';
        $user = Auth::guard('admin')->user();
        $data = AdminRevenue::where('id',$id)->firstOrFail();

        return view('admin.wallet-balance.show',compact('data','title','user'));
    }
    private function filters($users, $inputs, $request){
     
        if(isset($inputs['user_name']) && !empty($inputs['user_name'])){
            $users->whereHas('fromUser',function($q) use ($inputs){
                $q->where('first_name', 'like', '%' . $inputs['user_name'] . '%')->orWhere('last_name', 'like', '%' . $inputs['user_name'] . '%');
            });
         }
     
         if(isset($inputs['name']) && !empty($inputs['name'])){
            $users->whereHas('project',function($q) use($inputs){
                $q->where('title', 'like', '%' . $inputs['name'] . '%');
            });
         }
         if(isset($inputs['todz_id']) && !empty($inputs['todz_id'])){
            $users->whereHas('fromUser',function($q) use($inputs){
                $q->where('todz_id', 'like', '%' . $inputs['todz_id'] . '%');
            });
         }
       
       
       
        if($request->filled('start') && $request->filled('end'))
        {
            $date1 = str_replace('/', '-', $request->start);
            $date1 = date('Y-m-d', strtotime($date1));
            $date2 = str_replace('/', '-', $request->end);
            $date2 = date('Y-m-d', strtotime($date2));
            
            $users->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2);
        }
        elseif ($request->filled('start')) {
            $date = str_replace('/', '-', $request->start);
            $date = date('Y-m-d', strtotime($date));
            $users->whereDate('created_at','>=' ,$date);
        }
        elseif($request->filled('end')){
            $date = str_replace('/', '-', $request->end);
            $date = date('Y-m-d', strtotime($date));
            $users->whereDate('created_at','<=' ,$date);
        }else{}

        return $users;
    }

    public function export(Request $request){
        return (new \App\Exports\WalletBalanceExport)->download('walletDetail.xlsx');
    }  
}