<?php
namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
use App\Models\MangopayAccount;

class WalletBalanceExport implements FromCollection,WithHeadings,WithEvents 
{
    use Exportable;
    use \App\Traits\MangoPayManager;


    public function collection()
    {
        $data=DB::table('mangopay_accounts')
        ->leftJoin('users', 'users.id', '=', 'mangopay_accounts.user_id')
        ->select(DB::raw('CONCAT(users.first_name, users.last_name) AS full_name'),'users.todz_id','users.role','mangopay_accounts.mangopay_user_id','mangopay_accounts.mangopay_wallet_id')
        ->where('mangopay_accounts.user_id','<>',0)
        ->get();
          $token=$this->token();  
          foreach($data as $key=>$value){
              $walletInfo=$this->veiwWallet( $token->access_token,$value->mangopay_wallet_id);
             // dd($walletInfo);
               $data[$key]->amount=$walletInfo->Balance->Currency.' '.$walletInfo->Balance->Amount/100;
          }
        return $data;
    }
    public function headings(): array
    {
        return [
            'name','todz_id','user_type','mangopay_user_id','mangopay_wallet_id','wallet_balance'
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