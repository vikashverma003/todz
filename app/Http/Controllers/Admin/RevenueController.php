<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\AdminRevenue;
use App\Models\UserPermission;
use App\Models\Permission;
use App\Models\AdminComission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Mail\NewAdminAccountMail;
use Mail;
use App\Traits\CommonUtil;
use PDF;
use DB;
use \Carbon\Carbon;

class RevenueController extends Controller
{

    use CommonUtil;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $permissionName;
    protected $adminComission;
    public function __construct(AdminComission $adminComission){
        $this->permissionName = 'revenue_management_access';
        $this->adminComission = $adminComission;
    }

    /**
    * return dashboard view of admin side
    */
    public function index(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $title = 'Revenue';

        $user = Auth::guard('admin')->user();
        $inputs = $request->all();
        
        $orderby = 'desc';
        if(isset($inputs['orderby'])){
            $orderby = $inputs['orderby'];
        }
        $adminRevenue=AdminRevenue::query();
        $adminRevenue = self::filters($adminRevenue, $inputs, $request);

        $data = $adminRevenue->orderBy('id',$orderby)->paginate(10);

        if($request->ajax()){
            return view('admin.revenue.list',compact('data'));
        }
        return view('admin.revenue.index',compact('data','title','user'));
    }

    /**
    * return summary of revenue
    */
    public function getSummary(Request $request){
        abort_unless($this->helperCheckPermission("financial_reports_access"), 403);
        
        $title = 'Revenue';
        $user = Auth::guard('admin')->user();
        $inputs = $request->all();
        $orderby = 'desc';
        if(isset($inputs['orderby'])){
            $orderby = $inputs['orderby'];
        }
        $adminRevenue=AdminRevenue::query();
        $adminRevenue = self::filters($adminRevenue, $inputs, $request);

        $selectRaw = 'DATE_FORMAT(created_at,"%Y-%m-%d") as transaction_date,GROUP_CONCAT(DISTINCT(project_id)) as projects_id, SUM(amount) as total, COUNT(id) as total_transactions, COUNT(DISTINCT(project_id)) as total_projects';
        $groupBy = 'transaction_date';
        $orderBy = 'transaction_date';
        $list1 = 'total';
        $list2 = 'transaction_date';
        $data = $adminRevenue->selectRaw($selectRaw)->groupBy(DB::raw($groupBy))->orderBy('id',$orderby)->get();
        
        // if request is ajax then return data accordingly.
        if($request->ajax()){
            return view('admin.revenue.summary.list',compact('data'));
        }
        return view('admin.revenue.summary.index',compact('data','title','user'));
    }

    public function show($id){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $title = 'Transaction Details';
        $user = Auth::guard('admin')->user();
        $data = AdminRevenue::where('id',$id)->firstOrFail();

        return view('admin.revenue.show',compact('data','title','user'));
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
        return (new \App\Exports\RevenueExport)->download('revenues.xlsx');
    } 

    public function exportPdf(Request $request){
        $data = DB::table('admin_revenues')
                    ->leftJoin('users', 'users.id', '=', 'admin_revenues.from_user_id')
                    ->leftJoin('projects','admin_revenues.project_id','=','projects.id')
                   ->select('projects.title',DB::raw('CONCAT(users.first_name, users.last_name) AS full_name'),'users.todz_id','admin_revenues.amount','admin_revenues.transaction_id','admin_revenues.commission_from','admin_revenues.created_at')
                    ->get();
        // echo "<pre>";
        // print_r($data);die;

        $selectRaw = 'DATE_FORMAT(created_at,"%Y-%M") as monthM, SUM(amount) as count';
        $groupBy = 'monthM';
        $orderBy = 'monthM';
        $list1 = 'count';
        $list2 = 'monthM';
        $revenueData = AdminRevenue::orderBy(DB::raw($orderBy), 'ASC')->selectRaw($selectRaw)->groupBy(DB::raw($groupBy));
        $revenueData = $revenueData->get();

        $revenueResponse = [];
        if (count($revenueData)) {
            foreach ($revenueData as $key => $val) {
                $revenueResponse[] = ['label'=>$val[$list2],'value'=>number_format($val[$list1],2) ?? 0];
            }
        }
        // echo "<pre>";
        // print_r($revenueResponse);die;
        
        // $render = view('graphs.revenue-pdf-graph', compact('revenueResponse'))->render();


        $pdf = PDF::loadView('pdfTemplate.revenue-pdf', compact('data','revenueResponse'));

        return $pdf->stream('revenues.pdf');
    }

    public function revenueSummaryGraphs(Request $request){
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
        $revenueData = [];

        try{
            if($diff < 32){
                $selectRaw = 'DATE_FORMAT(created_at,"%d-%m-%Y") as dateM, SUM(amount) as count';
                $groupBy = 'dateM';
                $orderBy = 'dateM';
                $list1 = 'count';
                $list2 = 'dateM';
                $revenueData = AdminRevenue::orderBy(DB::raw($orderBy), 'ASC')->selectRaw($selectRaw)->groupBy(DB::raw($groupBy));
                if($date1 && $date2){
                    $revenueData = $revenueData->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2)->get();
                }else{
                    $revenueData = $revenueData->get();
                }
            }else
            {
                $selectRaw = 'DATE_FORMAT(created_at,"%Y-%M") as monthM, SUM(amount) as count';
                $groupBy = 'monthM';
                $orderBy = 'monthM';
                $list1 = 'count';
                $list2 = 'monthM';
                $revenueData = AdminRevenue::orderBy(DB::raw($orderBy), 'ASC')->selectRaw($selectRaw)->groupBy(DB::raw($groupBy));
                if($date1 && $date2){
                    $revenueData = $revenueData->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2)->get();
                }else{
                    $revenueData = $revenueData->get();
                }
            }

            $revenueResponse = [];

            if (count($revenueData)) {
                foreach ($revenueData as $key => $val) {
                    $revenueResponse[] = ['label'=>$val[$list2],'value'=>number_format($val[$list1],2) ?? 0];
                }
            }
            $data['revenueResponse'] = $revenueResponse;

            return response()->json(['status'=>true,'data'=>$data], 200);
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()], 400);
        }
    }
    public function getProfitSummary(Request $request){
        abort_unless($this->helperCheckPermission("financial_reports_access"), 403);
        
        $title = 'Gross Profit';
        $user = Auth::guard('admin')->user();
        $inputs = $request->all();
        $orderby = 'desc';
        if(isset($inputs['orderby'])){
            $orderby = $inputs['orderby'];
        }
        $adminRevenue=AdminRevenue::query();
        $adminRevenue = self::filters($adminRevenue, $inputs, $request);

        $selectRaw = 'DATE_FORMAT(created_at,"%d-%m-%Y") as transaction_date, SUM(amount) as total';
        $groupBy = 'transaction_date';
        $orderBy = 'transaction_date';
        $list1 = 'total';
        $list2 = 'transaction_date';
        $data = $adminRevenue->selectRaw($selectRaw)->groupBy(DB::raw($groupBy))->orderBy('id',$orderby)->paginate(10);
        $comission = $this->adminComission->getComission();
        if($request->ajax()){
            return view('admin.revenue.profit.summary.list',compact('data','comission'));
        }
        return view('admin.revenue.profit.summary.index',compact('data','title','user','comission'));
    }
     public function profitSummaryGraphs(Request $request){
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
        $revenueData = [];

        try{
            if($diff < 32){
                $selectRaw = 'DATE_FORMAT(created_at,"%d-%m-%Y") as dateM, SUM(amount) as count';
                $groupBy = 'dateM';
                $orderBy = 'dateM';
                $list1 = 'count';
                $list2 = 'dateM';
                $revenueData = AdminRevenue::orderBy(DB::raw($orderBy), 'ASC')->selectRaw($selectRaw)->groupBy(DB::raw($groupBy));
                if($date1 && $date2){
                    $revenueData = $revenueData->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2)->get();
                }else{
                    $revenueData = $revenueData->get();
                }
            }else
            {
                $selectRaw = 'DATE_FORMAT(created_at,"%Y-%M") as monthM, SUM(amount) as count';
                $groupBy = 'monthM';
                $orderBy = 'monthM';
                $list1 = 'count';
                $list2 = 'monthM';
                $revenueData = AdminRevenue::orderBy(DB::raw($orderBy), 'ASC')->selectRaw($selectRaw)->groupBy(DB::raw($groupBy));
                if($date1 && $date2){
                    $revenueData = $revenueData->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2)->get();
                }else{
                    $revenueData = $revenueData->get();
                }
            }

            $revenueResponse = [];
            $comission = $this->adminComission->getComission();

            if (count($revenueData)) {
                foreach ($revenueData as $key => $val) {
                    $revenueResponse[] = ['label'=>$val[$list2],'value'=>number_format($val[$list1] * $comission->project_comission /100,3) ?? 0];
                }
            }
            $data['revenueResponse'] = $revenueResponse;

            return response()->json(['status'=>true,'data'=>$data], 200);
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()], 400);
        }
    }
}