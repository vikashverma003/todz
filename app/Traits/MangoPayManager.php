<?php
namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait MangoPayManager {
    public function getBasicToken(){
        return base64_encode(env('MANGOPAY_CLIENT').':'.env('MANGOPAY_SECRET'));
    }
    
    public function token(){

        $endpoint='/oauth/token/';
        $data=['grant_type'=>'client_credentials'];
        $basic=$this->getBasicToken();
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = "Authorization: Basic ${basic}";
        $headers[] = 'Content-Type:application/x-www-form-urlencoded';
        $response=$this->mPostCurl($endpoint,json_encode($data),$headers);
        return  $response;
    }

    public function createMangoPayUser($token,$userDetail){
        $endpoint='/'.env('MANGOPAY_CLIENT').'/users/natural/';
        $data=[
            'FirstName' => $userDetail['FirstName'],
            'LastName' => $userDetail['LastName'],
            'Address' => 
            [
              'AddressLine1' => $userDetail['AddressLine1'],
              'AddressLine2' =>$userDetail['AddressLine2']??'',
              'City' => $userDetail['City'],
              'Region' => $userDetail['Region'],
              'PostalCode' => $userDetail['PostalCode'],
              'Country' =>$userDetail['Country'],
            ],
            'Birthday' => strtotime($userDetail['Birthday']),
            'Nationality' => $userDetail['Nationality'],
            'CountryOfResidence' => $userDetail['CountryOfResidence'],
            'Occupation' => $userDetail['Occupation'],
            'IncomeRange' =>3,//$userDetail['IncomeRange'],
            'Email' => $userDetail['Email'],
        ];
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = "Authorization: bearer ${token}";
        $headers[] = 'Content-Type:application/json';
        $response=$this->mPostCurl($endpoint,json_encode($data),$headers);
        return $response;
    }
   

    public function createWallet($token,$mangopayUserId,$user_role){
        $endpoint='/'.env('MANGOPAY_CLIENT').'/wallets/';
        $data=[
            'Owners' =>[
             $mangopayUserId
            ],
            'Description' => 'Todz '.$user_role,
            'Currency' => config('constants.CURRENCY'),
            'Tag' => $user_role,
        ];
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = "Authorization: bearer ${token}";
        $headers[] = 'Content-Type:application/json';
        $response=$this->mPostCurl($endpoint,json_encode($data),$headers);
        return $response;
    }

    public function transferFromWalletToWallet($token,$from_user_id,$to_user_id,$from_wallet_id,$to_wallet_id,$amount){
        $endpoint='/'.env('MANGOPAY_CLIENT').'/transfers/';
        $data=[
            'AuthorId' => $from_user_id,
            'CreditedUserId' => $to_user_id,
            'DebitedFunds' =>[
              'Currency' => config('constants.CURRENCY'),
              'Amount' => $amount*100,
            ],
            'Fees' =>[
              'Currency' => config('constants.CURRENCY'),
              'Amount' => 0,
            ],
            'DebitedWalletId' => $from_wallet_id,
            'CreditedWalletId' => $to_wallet_id,
        ];
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = "Authorization: bearer ${token}";
        $headers[] = 'Content-Type:application/json';
        $response=$this->mPostCurl($endpoint,json_encode($data),$headers);
        return $response;
    }

    public function cardReigstration($token,$user_id){
        $endpoint='/'.env('MANGOPAY_CLIENT').'/cardregistrations/';
        $data=[
            'UserId' => $user_id,
            'Currency' => config('constants.CURRENCY'),
            'CardType' => 'CB_VISA_MASTERCARD',
        ];
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = "Authorization: bearer ${token}";
        $headers[] = 'Content-Type:application/json';
        $response=$this->mPostCurl($endpoint,json_encode($data),$headers);
        return $response;
    }

    public function addMangoCard($endpoint,$accessKeyRef,$data){
        //    dd($endpoint,$accessKeyRef,$data);
        //  $endpoint='/'.env('MANGOPAY_CLIENT').'/cardregistrations/';
        $data=[
            'accessKeyRef' => $accessKeyRef,
            'data' => $data,
            'cardNumber' => "4242424242424242",
            'cardExpirationDate'=>"0222",
            'cardCvx'=>"123"
        ];
        //   dd($data);
        $headers = array();
        $headers[] = 'Accept: application/json';
        //$headers[] = "Authorization: bearer ${token}";
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $response=$this->mPostCurl1($endpoint,$data,$headers);
        return  $response;
       
    }

    public function viewACard($token,$card_id){
        $endpoint='/'.env('MANGOPAY_CLIENT').'/cards/'.$card_id;
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = "Authorization: bearer ${token}";
        // $headers[] = 'Content-Type:application/json';
        $response=$this->mGetCurl($endpoint,$headers);
        return  $response;
    }

    public function upadateCard($token,$card_id,$card_token){
        $endpoint='/'.env('MANGOPAY_CLIENT').'/CardRegistrations/'.$card_id;
        $data=[
            'RegistrationData' => $card_token
        ];
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = "Authorization: bearer ${token}";
        $headers[] = 'Content-Type:application/json';
        $response=$this->mPutCurl($endpoint,json_encode($data),$headers);
        return  $response;
    }

    public function listAllUserCards($token,$user_id){
        $endpoint='/'.env('MANGOPAY_CLIENT').'/users/'.$user_id.'/cards';
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = "Authorization: bearer ${token}";
        // $headers[] = 'Content-Type:application/json';
        $response=$this->mGetCurl($endpoint,$headers);
        return  $response;
    }


    public function veiwWallet($token,$wallet_id){
        $endpoint='/'.env('MANGOPAY_CLIENT').'/wallets/'.$wallet_id;

        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = "Authorization: bearer ${token}";
        // $headers[] = 'Content-Type:application/json';
        $response=$this->mGetCurl($endpoint,$headers);
        return  $response;
    }


    private function addPaymentToMangoWallet($token,$mango_user_id,$wallet_id,$amount,$card_type){
      $endpoint=env('MANGOPAY_CLIENT').'/payins/card/web/';
      $data=[
        'Tag' => 'custom meta',
        'AuthorId' => $mango_user_id,
        'CreditedUserId' => $mango_user_id,
        'DebitedFunds' => 
        array (
          'Currency' => config('constants.CURRENCY'),
          'Amount' => $amount*100,
        ),
        'Fees' => 
        array (
          'Currency' => config('constants.CURRENCY'),
          'Amount' => 0,
        ),
        'ReturnURL' => 'https://todz-admin.netsolutionindia.com/mangopay/thanks',
        'CardType' => $card_type,
        'CreditedWalletId' => $wallet_id,
        'SecureMode' => 'DEFAULT',
        'Culture' => 'EN',
        'TemplateURLOptions' => 
        array (
          'Payline' => 'https://todz-admin.netsolutionindia.com/payment-template',
          'PaylineV2' => 'https://todz-admin.netsolutionindia.com/payment-template',
        ),
        'StatementDescriptor' => 'Mar16',
      ];
      $headers = array();
      $headers[] = 'Accept: application/json';
      $headers[] = "Authorization: bearer ${token}";
   $headers[] = 'Content-Type:application/json';
// dd(env('MANGOPAY_URL').''.$endpoint);
//dd($endpoint,json_encode($data),$headers);
 $response=$this->mPostCurl($endpoint,json_encode($data),$headers,1);
return $response;
}

public function payInFromDirectCard($token,$mango_user_id,$wallet_id,$amount,$card_id,$redirect_url){
    $endpoint=env('MANGOPAY_CLIENT').'/payins/card/direct/';
    $data=[
        'AuthorId' => $mango_user_id,
        'CreditedUserId' => $mango_user_id,
        'CreditedWalletId' => $wallet_id,
        'DebitedFunds' =>[
          'Currency' => config('constants.CURRENCY'),
          'Amount' => $amount*100,
      ],
        'Fees' =>[
          'Currency' => config('constants.CURRENCY'),
          'Amount' => 0,
      ],
        'SecureModeReturnURL' => $redirect_url,
        'CardId' => $card_id,
        'SecureMode' => 'DEFAULT',
        'Billing' =>[
          'Address' => [
             'AddressLine1' => '1 Mangopay Street',
            'AddressLine2' => 'The Loop',
            'City' => 'Paris',
            'Region' => 'Ile de France',
            'PostalCode' => '75001',
            'Country' => 'FR',
      ],
      ],
        'StatementDescriptor' => 'Mar2016',
        'Culture' => 'EN',
        'Tag' => 'Custom description for this specific PayIn',
    ];

    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = "Authorization: bearer ${token}";
    $headers[] = 'Content-Type:application/json';
    // dd(env('MANGOPAY_URL').''.$endpoint);
    //dd($endpoint,json_encode($data),$headers);
    $response=$this->mPostCurl($endpoint,json_encode($data),$headers,1);
    return $response;
}


public function preauthrizePayment($token,$to_mango_user_id,$amount,$card_id){
  $endpoint=env('MANGOPAY_CLIENT').'/preauthorizations/card/direct';
  $data=[
    'AuthorId' => $to_mango_user_id,
    'DebitedFunds' => 
    array (
      'Currency' => config('constants.CURRENCY'),
      'Amount' => $amount*100,
    ),
    'Fees' => 
    array (
      'Currency' => config('constants.CURRENCY'),
      'Amount' => 2*100,
    ),
    'Billing' => 
    array (
      'Address' => 
      array (
        'AddressLine1' => '1 Mangopay Street',
        'AddressLine2' => 'The Loop',
        'City' => 'Paris',
        'Region' => 'Ile de France',
        'PostalCode' => '75001',
        'Country' => 'IN',
      ),
    ),
    'SecureMode' => 'DEFAULT',
    'Culture' => 'EN',
    'CardId' =>$card_id,
    'SecureModeReturnURL' => 'https://todz-admin.netsolutionindia.com/mangopay/thanks',
    'StatementDescriptor' => 'invoice 21',
  ];
  $headers = array();
  $headers[] = 'Accept: application/json';
  $headers[] = "Authorization: bearer ${token}";
$headers[] = 'Content-Type:application/json';
// dd(env('MANGOPAY_URL').''.$endpoint);
//dd($endpoint,json_encode($data),$headers);
$response=$this->mPostCurl($endpoint,json_encode($data),$headers,1);
return $response;
}

    public function createPreAuthorizedPayIn($token,$from_mango_user_id,$to_user_id,$wallet_user_id,$preauthorizationId){
        $endpoint=env('MANGOPAY_CLIENT').'/payins/preauthorized/direct/';
        $data=[
            'AuthorId' => $from_mango_user_id,
            'CreditedUserId' => $to_user_id,
            'CreditedWalletId' => $wallet_user_id,
            'DebitedFunds' => [
                'Currency' => config('constants.CURRENCY'),
                'Amount' => 10,
            ],
            'Fees' => [
                'Currency' =>config('constants.CURRENCY'),
                'Amount' => 5,
            ],
            'PreauthorizationId' => $preauthorizationId,
        ];
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = "Authorization: bearer ${token}";
        $headers[] = 'Content-Type:application/json';
        // dd(env('MANGOPAY_URL').''.$endpoint);
        //dd($endpoint,json_encode($data),$headers);
        $response=$this->mPostCurl($endpoint,json_encode($data),$headers,1);
        return $response;
    }

    public function viewPayin($token,$transaction_id){
        $endpoint=env('MANGOPAY_CLIENT').'/payins/'.$transaction_id.'/';
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = "Authorization: bearer ${token}";
        // $headers[] = 'Content-Type:application/json';
        $response=$this->mGetCurl($endpoint,$headers);
        return $response;
    }

    public function createBankAccount($token,$user_id,$type,$data){
        $endpoint=env('MANGOPAY_CLIENT').'/users/'.$user_id.'/bankaccounts/'.$type.'/';
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = "Authorization: bearer ${token}";
        $headers[] = 'Content-Type:application/json';
        // dd(env('MANGOPAY_URL').''.$endpoint);
        //dd($endpoint,json_encode($data),$headers);
        $response=$this->mPostCurl($endpoint,json_encode($data),$headers,1);
        return $response;
    }

    public function createKycDoc($token,$user_id,$type){
        $endpoint=env('MANGOPAY_CLIENT').'/users/'.$user_id.'/kyc/documents/';
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = "Authorization: bearer ${token}";
        $headers[] = 'Content-Type:application/json';
        $data=['Type'=>$type];

        $response=$this->mPostCurl($endpoint,json_encode($data),$headers,1);
        return $response;
    }

    public function createKycPage($token,$user_id,$kycDocId,$file){
        $endpoint=env('MANGOPAY_CLIENT').'/users/'.$user_id.'/kyc/documents/'.$kycDocId.'/pages/';
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = "Authorization: bearer ${token}";
        $headers[] = 'Content-Type:application/json';
        $data=['File'=>$file];

        $response=$this->mPostCurl($endpoint,json_encode($data),$headers,1);
        return $response;
    }

    public function submitKycDoc($token,$user_id,$kycDocId){
        $endpoint=env('MANGOPAY_CLIENT').'/users/'.$user_id.'/kyc/documents/'.$kycDocId;
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = "Authorization: bearer ${token}";
        $headers[] = 'Content-Type:application/json';
        $data=["Status"=>"VALIDATION_ASKED"];

        $response=$this->mPutCurl($endpoint,json_encode($data),$headers,1);
        return $response;
    }


    public function listKycDoc($token,$user_id){
        $endpoint=env('MANGOPAY_CLIENT').'/users/'.$user_id.'/kyc/documents/';
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = "Authorization: bearer ${token}";
        $headers[] = 'Content-Type:application/json';

        $response=$this->mGetCurl($endpoint,$headers);
        return $response;
    }

    public function listBankAccount($token,$user_id){
        $endpoint=env('MANGOPAY_CLIENT').'/users/'.$user_id.'/bankaccounts/';
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = "Authorization: bearer ${token}";
        // $headers[] = 'Content-Type:application/json';
        $response=$this->mGetCurl($endpoint,$headers);
        return $response;
    }

public function createPayOut($token,$data){
    $endpoint=env('MANGOPAY_CLIENT').'/payouts/bankwire/';
    $data=[
        'AuthorId' => $data['mangopay_user_id'],
        'DebitedFunds' => [
            'Currency' => config('constants.CURRENCY'),
            'Amount' => $data['amount'],
        ],
        'Fees' =>[
            'Currency' => config('constants.CURRENCY'),
            'Amount' => 0,
        ],
        'BankAccountId' => $data['bank_id'],
        'DebitedWalletId' => $data['wallet_id'],
        'BankWireRef' => '',
    ];

    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = "Authorization: bearer ${token}";
    $headers[] = 'Content-Type:application/json';
    // dd(env('MANGOPAY_URL').''.$endpoint);
    //dd($endpoint,json_encode($data),$headers);
    $response=$this->mPostCurl($endpoint,json_encode($data),$headers,1);
    return $response;
}

public function viewPayout($token,$payout_id){
    $endpoint=env('MANGOPAY_CLIENT').'/payouts/'.$payout_id;

    $headers = array();
    $headers[] = 'Accept: application/json';
    $headers[] = "Authorization: bearer ${token}";
    $headers[] = 'Content-Type:application/json';
    // dd(env('MANGOPAY_URL').''.$endpoint);
    //dd($endpoint,json_encode($data),$headers);
    $response=$this->mGetCurl($endpoint,$headers);
    return $response;
}
    private function mPostCurl($endpoint,$data,$headers,$f=0){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, env('MANGOPAY_URL').''.$endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
           
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            if($f==1){
                //   dd($result,$data);
            }
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            return json_decode($result); 
    }
    private function mPutCurl($endpoint,$data,$headers){
      $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, env('MANGOPAY_URL').''.$endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
           
             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            return json_decode($result); 
    }

    private function mGetCurl($endpoint,$headers){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,  env('MANGOPAY_URL').''.$endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
       
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return json_decode($result); 
    } 
}