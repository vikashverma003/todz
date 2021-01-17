<?php
namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class RevenueExport implements FromCollection,WithHeadings,WithEvents 
{
    use Exportable;

    public function collection()
    {
        return  DB::table('admin_revenues')
        ->leftJoin('users', 'users.id', '=', 'admin_revenues.from_user_id')
        ->leftJoin('projects','admin_revenues.project_id','=','projects.id')
       ->select('projects.title',DB::raw('CONCAT(users.first_name, users.last_name) AS full_name'),'users.todz_id','admin_revenues.amount','admin_revenues.transaction_id','admin_revenues.commission_from','admin_revenues.created_at')
        ->get();
    }
    public function headings(): array
    {
        return [
            'project_name','from_name','todz_id','amount','transacton_id','commission_from','date'
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