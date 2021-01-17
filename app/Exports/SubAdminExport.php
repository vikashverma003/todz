<?php
namespace App\Exports;

use App\Admin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class SubAdminExport implements FromCollection,WithHeadings,WithEvents 
{
    use Exportable;

    public function collection()
    {
        return  Admin::select('first_name','last_name','email','phone_code','phone_number','account_status')->where('is_super',0)->get();
    }
    public function headings(): array
    {
        return [
            'first_name','last_name','email','phone_code','phone_number','account_status'
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