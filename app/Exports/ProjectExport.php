<?php
namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ProjectExport implements FromCollection,WithHeadings,WithEvents 
{
    use Exportable;

    public function collection()
    {
        return  DB::table('projects')
        ->join('users', 'users.id', '=', 'projects.user_id')
       ->select(DB::raw('CONCAT(users.first_name, users.last_name) AS full_name'),'projects.status','projects.title',DB::raw('CONCAT(projects.duration_month," Month", projects.duration_day," Days")'),'projects.cost','projects.created_at')
        ->get();
    }
    public function headings(): array
    {
        return [
            'client_name','status','project_title','duration','cost','date'
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