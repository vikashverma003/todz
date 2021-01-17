<?php
namespace App\Exports;

use App\User;
use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ProjectWiseSummaryExport implements FromCollection,WithHeadings,WithEvents 
{
    use Exportable;

    public function collection()
    {
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

        $tempArr = [];
        if($data->isNotEmpty()){
            $i= 1;

            foreach ($data as $key => $value) {
                $tempArr['sr_no'] = $i;
                $tempAr['title'] = $value->title;
                $tempArr['created_at'] = $value->created_at ? date('d/m/Y', strtotime($value->created_at)) : 'N/A';
                $tempArr['allocation_date'] = $value->created_at ? date('d/m/Y', strtotime($value->allocation_date)) : 'N/A';
                $tempArr['duration']=($value->duration_month >0 ? $value->duration_month.' month': '').' '.($value->duration_day >0 ? $value->duration_day.' days': '');
                $tempArr['agreedAmount']=($value->no_of_hours*($value->main_talent->hourly_rate ?? 0) ?? 0);
                $tempArr['recivedAmount']=($value->transactions->sum('amount') ?? 0);
                $tempArr['paidAmount']=($value->payments->sum('amount') ?? 0);
                $tempArr['talent_id']=($value->talent->todz_id ?? "N/A");
                $tempArr['talent_name']= ($value->talent->first_name ?? '').' '.($value->talent->last_name ?? '');
                $tempArr['client_name']= ($value->client->first_name ?? '').' '.($value->client->last_name ?? '');

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
                $tempArr['status']= $status;
                return;
            }
        }
        return $tempArr;
    }

    public function headings(): array
    {
        return [
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
    }
     // freeze the first row with headings
     public function registerEvents(): array
     {
         return [            
             AfterSheet::class => function(AfterSheet $event) {
                 $event->sheet->freezePane('A2', 'A2');
             },
         ];
     }
}