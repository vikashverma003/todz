<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Mail;
use App\Models\ProjectPayment;
use App\Models\Transaction;
use App\Models\Project;
use DB;
use \Carbon\Carbon;
use PDF;

class ReportController extends Controller
{

    use \App\Traits\CommonUtil;

    public $permissionName;

    public function __construct(){
        $this->permissionName = 'financial_reports_access';
    }

   
    public function projectWiseSummary(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $title = 'Project Wise Summary';
        $user = Auth::guard('admin')->user();
        $dateRes = self::getDates($request);
        $date1 = $dateRes['date1'];
        $date2 = $dateRes['date2'];


        $projects=Project::whereNotIn('status',[config('constants.project_status.IN-COMPLETE'),config('constants.project_status.PENDING')]);

        $data = $projects->with(['talent','client','main_talent','project_talent','payments' => function($query) {
           $query->select('id','project_id','amount');
        
        },'transactions'=>function($query){
           $query->select('id','project_id','amount')->where('transaction_type','client');
        
        }])->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2)->orderBy('id','desc')->get();
        
        $recivedAmount = $agreedAmount = $paidAmount = 0;

        
        $projectsId = [];
        foreach ($data as $key => $value) {
            $projectsId[] = $value->id;
            $projectTalent=\App\Models\ProjectTalent::where('talent_user_id',$value->talent_user_id)->where('project_id',$value->id)->first();
            if($projectTalent){
                $value->no_of_hours = $projectTalent->no_of_hours;
                $value->allocation_date = $projectTalent->updated_at;
                $agreedAmount+=$projectTalent->no_of_hours*($value->main_talent->hourly_rate ?? 0);
            }else{
                $value->no_of_hours = 0;
                $value->allocation_date = $value->created_at;
            }

            $paidAmount+=($value->payments->sum('amount') ?? 0);
            $recivedAmount+=($value->transactions->sum('amount') ?? 0);

        }

        $agreedAmount = number_format($agreedAmount, 2);
        $recivedAmount = number_format($recivedAmount, 2);
        $paidAmount = number_format($paidAmount, 2);
        
        // echo "<pre>";
        // print_r($data->toArray());die;

        if($request->ajax()){
            $html = view('admin.reports.project-wise-summary.list',compact('data'))->render();
            return response()->json(['status'=>true,'html'=>$html,'agreedAmount'=>$agreedAmount,'recivedAmount'=>$recivedAmount,'paidAmount'=>$paidAmount], 200);
        }

        return view('admin.reports.project-wise-summary.index',compact('data','agreedAmount','paidAmount','recivedAmount','title','user'));
    }

    // projects which are marked as disputed
    public function disputedProjectWiseSummary(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $title = 'Disputed Project Wise Summary';
        $user = Auth::guard('admin')->user();
        $dateRes = self::getDates($request);
        $date1 = $dateRes['date1'];
        $date2 = $dateRes['date2'];

        $projects=Project::whereIn('status',[config('constants.project_status.DISPUTE')]);

        $data = $projects->with(['talent','client','main_talent','project_talent','payments' => function($query) {
           $query->select('id','project_id','amount');
        
        },'transactions'=>function($query){
           $query->select('id','project_id','amount')->where('transaction_type','client');
        
        }])->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2)->orderBy('id','desc')->get();
        
        $recivedAmount = $agreedAmount = $paidAmount = 0;

        
        $projectsId = [];
        foreach ($data as $key => $value) {
            $projectsId[] = $value->id;

            $projectTalent=\App\Models\ProjectTalent::where('talent_user_id',$value->talent_user_id)->where('project_id',$value->id)->first();
            if($projectTalent){
                $value->no_of_hours = $projectTalent->no_of_hours;
                $value->allocation_date = $projectTalent->updated_at;
                $agreedAmount+=$projectTalent->no_of_hours*($value->main_talent->hourly_rate ?? 0);
            }else{
                $value->no_of_hours = 0;
                $value->allocation_date = $value->created_at;
            }

            $paidAmount+=($value->payments->sum('amount') ?? 0);
            $recivedAmount+=($value->transactions->sum('amount') ?? 0);
            
        }

        $agreedAmount = number_format($agreedAmount, 2);
        $recivedAmount = number_format($recivedAmount, 2);
        $paidAmount = number_format($paidAmount, 2);
        
        // echo "<pre>";
        // print_r($data->toArray());die;

        if($request->ajax()){
            
            $html = view('admin.reports.dispute-project-wise-summary.list',compact('data'))->render();
            return response()->json(['status'=>true,'html'=>$html,'agreedAmount'=>$agreedAmount,'recivedAmount'=>$recivedAmount,'paidAmount'=>$paidAmount], 200);
        }

        return view('admin.reports.dispute-project-wise-summary.index',compact('data','agreedAmount','paidAmount','recivedAmount','title','user'));
    }

    // project which are deleted by client in which todder not hired
    public function terminatedProjectWiseSummary(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $title = 'Terminated Project Wise Summary';
        $user = Auth::guard('admin')->user();
        $dateRes = self::getDates($request);
        $date1 = $dateRes['date1'];
        $date2 = $dateRes['date2'];

        $projects=Project::onlyTrashed();
        $data = $projects->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2)->orderBy('id','desc')->get();
        
        $agreedAmount = 0;
        foreach ($data as $key => $value) {
            $agreedAmount+=$value->cost;
        }
        $agreedAmount = number_format($agreedAmount, 2);

        if($request->ajax()){
            $html = view('admin.reports.terminate-project-wise-summary.list',compact('data'))->render();
            return response()->json(['status'=>true,'html'=>$html,'agreedAmount'=>$agreedAmount], 200);
        }
        return view('admin.reports.terminate-project-wise-summary.index',compact('data','agreedAmount','title','user'));
    }

    public function skillsWiseSummary(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $title = 'Skills Wise Summary';
        $user = Auth::guard('admin')->user();
        $dateRes = self::getDates($request);
        $date1 = $dateRes['date1'];
        $date2 = $dateRes['date2'];
        
        $data=DB::table('skills')
                ->selectRaw('skills.id,skills.name, GROUP_CONCAT(DISTINCT(project_skills.project_id)) as projects_id, COUNT(DISTINCT(project_skills.project_id)) as total_projects, COUNT(DISTINCT(project_talents.talent_user_id)) as total_talents,COUNT(DISTINCT(users.country)) as total_countries')
                ->leftJoin('project_skills', 'project_skills.skill_id', '=', 'skills.id')
                ->leftJoin('project_talents', 'project_talents.project_id', '=', 'project_skills.project_id')
                ->leftJoin('projects', 'projects.id', '=', 'project_talents.project_id')
                ->leftJoin('users', 'users.id', '=', 'projects.user_id')
                ->where('project_talents.status', 1)
                ->groupBy('skills.name')
                ->orderBy('skills.id','desc')
                ->get();
        
        // echo "<pre>";
        // print_r($data->toArray());die;
        if($request->ajax()){
            $html = view('admin.reports.skills-wise-summary.list',compact('data'))->render();
            return response()->json(['status'=>true,'html'=>$html], 200);
        }

        return view('admin.reports.skills-wise-summary.index',compact('data','title','user'));
    }

    public function talentsPerformanceRatings(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $title = 'Talents Performance Rating';
        $user = Auth::guard('admin')->user();
        $dateRes = self::getDates($request);
        $date1 = $dateRes['date1'];
        $date2 = $dateRes['date2'];
        
        $users= \App\User::where('role',config('constants.role.TALENT'))->where('registration_step',3);
        $data = $users->select('id','created_at','todz_id','first_name','last_name')->with(['ratings','talent','talent.skills'])->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2)->orderBy('created_at','desc')->get();
        
        // echo "<pre>";
        // print_r($data->toArray());die;
        if($request->ajax()){
            $html = view('admin.reports.talent-performance-rating.list',compact('data'))->render();
            return response()->json(['status'=>true,'html'=>$html], 200);
        }

        return view('admin.reports.talent-performance-rating.index',compact('data','title','user'));
    }

    private function getDates($request){
        if($request->filled('start') && $request->filled('end')){
            $date1 = str_replace('/', '-', $request->start);
            $date1 = date('Y-m-d', strtotime($date1));
            $date2 = str_replace('/', '-', $request->end);
            $date2 = date('Y-m-d', strtotime($date2));
        }else{
            $date1 = Carbon::now()->subDays(30)->format('Y-m-d');

            $date2 = date('Y-m-d');
        }
        return ['date1'=>$date1,'date2'=>$date2];
    }

    public function exportProjectWiseSummaryExcel(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $projects=Project::whereNotIn('status',[config('constants.project_status.IN-COMPLETE'),config('constants.project_status.PENDING')]);

        $data = $projects->with(['talent','client','main_talent','project_talent','payments' => function($query) {
           $query->select('id','project_id','amount');
        
        },'transactions'=>function($query){
           $query->select('id','project_id','amount')->where('transaction_type','client');
        
        }])->orderBy('id','desc')->get();
        
        $recivedAmount = $agreedAmount = $paidAmount = 0;

        
        $projectsId = [];
        foreach ($data as $key => $value) {
            $projectsId[] = $value->id;
            $projectTalent=\App\Models\ProjectTalent::where('talent_user_id',$value->talent_user_id)->where('project_id',$value->id)->first();
            if($projectTalent){
                $value->no_of_hours = $projectTalent->no_of_hours;
                $value->allocation_date = $projectTalent->updated_at;
                $agreedAmount+=$projectTalent->no_of_hours*($value->main_talent->hourly_rate ?? 0);
            }else{
                $value->no_of_hours = 0;
                $value->allocation_date = $value->created_at;
            }

            $paidAmount+=($value->payments->sum('amount') ?? 0);
            $recivedAmount+=($value->transactions->sum('amount') ?? 0);
        }

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=file.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

            
        $columns = [
            'Sr. No.',
            'Project',
            'Creation Date',
            'Allocation Date',
            'Project Duration',
            'Agreed Amount',
            'Recieved Amount',
            'Paid Amount',
            'Talent ID',
            'Talent Name',
            'Client Name',
            'Status'
        ];

        $callback = function() use ($data, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            $i= 1;
            foreach($data as $value) {
                $status = '';
                if($value->status=='completed')
                {
                    $status = 'Completed';
                }
                elseif ($value->status=="dispute") {
                    $status = $value->status;
                }
                elseif ($value->status=="hired") {
                    $status = 'In-Progress';
                }else{
                    $status = $value->status;
                }
                fputcsv($file, 
                    array(
                        $i++, 
                        $value->title, 
                        ($value->created_at ? date('d/m/Y', strtotime($value->created_at)) : 'N/A'),
                        ($value->created_at ? date('d/m/Y', strtotime($value->allocation_date)) : 'N/A'),
                        (($value->duration_month >0 ? $value->duration_month.' month': '').' '.($value->duration_day >0 ? $value->duration_day.' days': '')),
                        ($value->no_of_hours*($value->main_talent->hourly_rate ?? 0) ?? 0),
                        ($value->transactions->sum('amount') ?? 0),
                        ($value->payments->sum('amount') ?? 0),
                        ($value->talent->todz_id ?? "N/A"),
                        ($value->talent->first_name ?? '').' '.($value->talent->last_name ?? ''),
                        ($value->client->first_name ?? '').' '.($value->client->last_name ?? ''),
                        $status
                     ));
            }
            fclose($file);
        };
        
        return response()->streamDownload($callback, 'reports-' . date('d-m-Y-H:i:s').'.csv', $headers);

        return \Excel::create('reports', function($excel) use($tempArr) {
            $excel->sheet('Sheetname', function($sheet) use($tempArr) {
                $sheet->fromArray($tempArr);
            });

        })->export('xls');
        //return (new \App\Exports\ProjectWiseSummaryExport)->download('reports.xlsx');
    }

    public function exportProjectWiseSummaryPdf(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        // projectwisesummary.pdf

        $projects=Project::whereNotIn('status',[config('constants.project_status.IN-COMPLETE'),config('constants.project_status.PENDING')]);

        $data = $projects->with(['talent','client','main_talent','project_talent','payments' => function($query) {
           $query->select('id','project_id','amount');
        
        },'transactions'=>function($query){
           $query->select('id','project_id','amount')->where('transaction_type','client');
        
        }])->orderBy('id','desc')->get();
        
        $recivedAmount = $agreedAmount = $paidAmount = 0;

        
        $projectsId = [];
        foreach ($data as $key => $value) {
            $projectsId[] = $value->id;
            $projectTalent=\App\Models\ProjectTalent::where('talent_user_id',$value->talent_user_id)->where('project_id',$value->id)->first();
            if($projectTalent){
                $value->no_of_hours = $projectTalent->no_of_hours;
                $value->allocation_date = $projectTalent->updated_at;
                $agreedAmount+=$projectTalent->no_of_hours*($value->main_talent->hourly_rate ?? 0);
            }else{
                $value->no_of_hours = 0;
                $value->allocation_date = $value->created_at;
            }

            $paidAmount+=($value->payments->sum('amount') ?? 0);
            $recivedAmount+=($value->transactions->sum('amount') ?? 0);
        }
        $pdf = PDF::loadView('pdfTemplate.projectwisesummary', compact('data'))->setPaper('a4', 'landscape');

        return $pdf->stream('reports.pdf');
    }

    
}