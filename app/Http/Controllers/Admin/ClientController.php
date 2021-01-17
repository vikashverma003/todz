<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\AppsCountryRepositoryInterface;
use DB;
use \Carbon\Carbon;


class ClientController extends Controller
{
    use \App\Traits\CommonUtil;

    public $permissionName;

    public function __construct(UserRepositoryInterface $user,
    AppsCountryRepositoryInterface $appCountry){
        $this->user=$user;
        $this->permissionName = 'client_management_access';
        $this->appCountry=$appCountry;
    }

    public function index(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $user=Auth::guard('admin')->user();

        $usr= \App\User::where('role',config('constants.role.CLIENT'))->where('registration_step',2);
        $inputs = $request->all();
        $orderby = 'desc';

        if(isset($inputs['name'])){
            $usr->where('first_name', 'like', '%' . $inputs['name'] . '%')->orWhere('last_name', 'like', '%' . $inputs['name'] . '%');
        }
        if(isset($inputs['email'])){
            $usr->where('email', 'like', '%' . $inputs['email'] . '%');
        }
        if(isset($inputs['country'])){
            $usr->whereIn('country',$inputs['country']);
        }
        if(isset($inputs['todz_id'])){
            $usr->where('todz_id', 'like', '%' . $inputs['todz_id'] . '%');
        }
        if(isset($inputs['phone'])){
            $usr->where('phone_number', 'like', '%' . $inputs['phone'] . '%');
        }
        if(isset($inputs['entity'])){
            $usr->where('entity', 'like', '%' . $inputs['entity'] . '%');
        }
        if(isset($inputs['orderby'])){
            $orderby = $inputs['orderby'];
        }

        if($request->filled('start') && $request->filled('end'))
        {
            $date1 = str_replace('/', '-', $request->start);
            $date1 = date('Y-m-d', strtotime($date1));
            $date2 = str_replace('/', '-', $request->end);
            $date2 = date('Y-m-d', strtotime($date2));
            
            $usr->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2);
        }
        elseif ($request->filled('start')) {
            $date = str_replace('/', '-', $request->start);
            $date = date('Y-m-d', strtotime($date));
            $usr->whereDate('created_at','>=' ,$date);
        }
        elseif($request->filled('end')){
            $date = str_replace('/', '-', $request->end);
            $date = date('Y-m-d', strtotime($date));
            $usr->whereDate('created_at','<=' ,$date);
        }else{}

        $clients = $usr->with(['projects'])->orderBy('id',$orderby)->paginate(25);
        
        if($request->ajax()){
            return view('admin.client.list', compact('clients'));
        }
        $allCountries= $this->appCountry->all();
        return view('admin.client.index', ['title' => 'Client Manager','user'=>$user,'clients'=>$clients,'allCountries'=>$allCountries]);
    }

    // show details of client user
    public function show(Request $req, $id){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $user=Auth::guard('admin')->user();
        $title="Client Manager";
        $client = $this->user->getUserById($id);
        if($client->role!='client'){
            return redirect('404');
        }
        $projects  = \App\Models\Project::where('user_id', $id)->with(['client','talents'])->get();

        return view('admin.client.show',['title' => $title,'user'=>$user,'client'=>$client,'projects'=>$projects]);
    }

    public function update(Request $req){
        
    }
    public function edit(Request $req,$id){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $user=Auth::guard('admin')->user();
        $title="Client Manager";
        $client = $this->user->getUserById($id);
        return view('admin.client.edit',['title' => $title,'user'=>$user,'client'=>$client]);
    }

    public function destroy(Request $red,$id){
    try{
        $this->user->delete($id);
        return response()->json([],200);
    }catch(\Exception $e){
        return response()->json([],419);
    }
    }
    public function export(Request $request){
        return (new \App\Exports\ClientExport)->download('clients.xlsx');
    }
    public function getSummary(Request $request){
        abort_unless($this->helperCheckPermission("financial_reports_access"), 403);
        
        $title = 'CLient';
        $user = Auth::guard('admin')->user();
        $inputs = $request->all();
        $orderby = 'desc';
        if(isset($inputs['orderby'])){
            $orderby = $inputs['orderby'];
        }
        $users= \App\User::where('role',config('constants.role.CLIENT'))->where('registration_step',2);
        $users = self::filters($users, $inputs, $request);
        $selectRaw = 'DATE_FORMAT(created_at,"%d-%m-%Y") as registration_date,COUNT(*) as count';
        $groupBy = 'registration_date';
        $orderBy = 'registration_date';
        $list1 = 'count';
        $list2 = 'registration_date';
        $data = $users->selectRaw($selectRaw)->groupBy(DB::raw($groupBy))->orderBy('id',$orderby)->paginate(10);
        $clients = $data;

        if($request->ajax()){
            return view('admin.client.summary.list',compact('data','clients'));
        }
        return view('admin.client.summary.index',compact('data','title','user','clients'));
    }
     private function filters($usr, $inputs, $request){
     
       if(isset($inputs['name'])){
            $usr->where('first_name', 'like', '%' . $inputs['name'] . '%')->orWhere('last_name', 'like', '%' . $inputs['name'] . '%');
        }
        if(isset($inputs['email'])){
            $usr->where('email', 'like', '%' . $inputs['email'] . '%');
        }
        if(isset($inputs['country'])){
            $usr->whereIn('country',$inputs['country']);
        }
        if(isset($inputs['todz_id'])){
            $usr->where('todz_id', 'like', '%' . $inputs['todz_id'] . '%');
        }
        if(isset($inputs['phone'])){
            $usr->where('phone_number', 'like', '%' . $inputs['phone'] . '%');
        }
        if(isset($inputs['entity'])){
            $usr->where('entity', 'like', '%' . $inputs['entity'] . '%');
        }
        if(isset($inputs['orderby'])){
            $orderby = $inputs['orderby'];
        }

        if($request->filled('start') && $request->filled('end'))
        {
            $date1 = str_replace('/', '-', $request->start);
            $date1 = date('Y-m-d', strtotime($date1));
            $date2 = str_replace('/', '-', $request->end);
            $date2 = date('Y-m-d', strtotime($date2));
            
            $usr->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2);
        }
        elseif ($request->filled('start')) {
            $date = str_replace('/', '-', $request->start);
            $date = date('Y-m-d', strtotime($date));
            $usr->whereDate('created_at','>=' ,$date);
        }
        elseif($request->filled('end')){
            $date = str_replace('/', '-', $request->end);
            $date = date('Y-m-d', strtotime($date));
            $usr->whereDate('created_at','<=' ,$date);
        }else{}
        return $usr;
    }
    public function clientSummaryGraphs(Request $request){
        $start =  $request->start;
        $end = $request->end;
        $data = [];
        $diff = 35;
        $date1 = $date2 = '';
        if($start && $end){
            $date1 = str_replace('/', '-', $start);
            $date1 = date('Y-m-d', strtotime($date1));
            $date2 = str_replace('/', '-', $end);
            $date2 = date('Y-m-d', strtotime($date2));

            $dd1 = Carbon::parse($date1);
            $dd2 = Carbon::parse($date2);
            $diff = $dd1->diffInDays($dd2);
        }
        
        $projectLabel=[];
        $projectCount=[];
        $clientData = [];

        try{
            $users= \App\User::where('role',config('constants.role.CLIENT'))->where('registration_step',2);
            if($diff < 32){
                $selectRaw = 'DATE_FORMAT(created_at,"%d-%m-%Y") as dateM, COUNT(*) as count';
                $groupBy = 'dateM';
                $orderBy = 'dateM';
                $list1 = 'count';
                $list2 = 'dateM';
                $clientData = $users->orderBy(DB::raw($orderBy), 'ASC')->selectRaw($selectRaw)->groupBy(DB::raw($groupBy))->get();
                if($date1 && $date2){
                    $clientData = $clientData->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2)->get();
                    dd($clientData);
                }else{
                    $clientData = $clientData->get();
                }
            }else
            {
                $selectRaw = 'DATE_FORMAT(created_at,"%Y-%M") as monthM, COUNT(*) as count';
                $groupBy = 'monthM';
                $orderBy = 'monthM';
                $list1 = 'count';
                $list2 = 'monthM';
                $clientData = $users->orderBy(DB::raw($orderBy), 'ASC')->selectRaw($selectRaw)->groupBy(DB::raw($groupBy));
                if($date1 && $date2){
                    $clientData = $clientData->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2)->get();
                }
                else{
                    $clientData = $clientData->get();
                }
            }

            $clientResponse = [];
            if (count($clientData)) {
                foreach ($clientData as $key => $val) {
                    $clientResponse[] = ['label'=>$val[$list2],'value'=>number_format($val[$list1],2) ?? 0];
                }
            }
            $data['clientResponse'] = $clientResponse;

            return response()->json(['status'=>true,'data'=>$data,'clientData'=>$clientData], 200);
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()], 400);
        }
    }   
}
