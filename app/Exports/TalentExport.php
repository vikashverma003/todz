<?php
namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class TalentExport implements FromCollection,WithHeadings,WithEvents 
{
    use Exportable;

    public function collection()
    {
        return  DB::table('users')
        ->join('talents', 'users.id', '=', 'talents.user_id')
       
        ->select('users.first_name','users.last_name','users.email','users.phone_code','users.phone_number','users.account_status','users.todz_id','users.country','talents.job_field','users.created_at')
        ->where('users.role',config('constants.role.TALENT'))
        ->where('users.registration_step',3)
        ->get();
    }
    public function headings(): array
    {
        return [
            'first_name','last_name','email','phone_code','phone_number','account_status','todz_id','country','job_field','date'
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