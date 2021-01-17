<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\MangopayAccountRepositoryInterface;
use App\Repositories\Interfaces\AppsCountryRepositoryInterface;
use Auth;
use App\Repositories\Interfaces\SavedUserCardRepositoryInterface;
use App\Repositories\Interfaces\BankAccountRepositoryInterface;
use App\Models\BankPayout;
use App\Mail\CardAdded;
use Mail;
use Validator;


class MangoPayController extends Controller
{
    use \App\Traits\MangoPayManager;
    use \App\Traits\CommonUtil;
    private $mangopayAccount;
    private $appsCountry;
    
    public function __construct(MangopayAccountRepositoryInterface $mangopayAccount,
    AppsCountryRepositoryInterface $appsCountry,SavedUserCardRepositoryInterface $saveUserCard,
    BankAccountRepositoryInterface $bankAccount,
    BankPayout $bankPayout){
        $this->mangopayAccount=$mangopayAccount;
        $this->appsCountry=$appsCountry;
        $this->saveUserCard=$saveUserCard;
        $this->bankAccount=$bankAccount;
        $this->bankPayout=$bankPayout;
    }

    private function getRedirectTo(){
        
        if(Auth::guard('admin')->check()){
            return 'admin/payment-details';
        }else{
            $currentUser=Auth::user();
            if($currentUser->role==config('constants.role.CLIENT')){
                return $currentUser->role.'/profile';
            }
            elseif ($currentUser->role==config('constants.role.TALENT')) {
                return $currentUser->role.'/profile';
            }
            else{
                return '/';
            }
        }
    }

    public function index()
    {
        if(Auth::guard('admin')->check()){
            $user=Auth::guard('admin')->user();
            if(!is_null($user->mangopayUser)){
                return redirect("admin/payment-details");
            }
        }else{
            $user=Auth::user();
            if(!is_null($user->mangopayUser)){
                return redirect($user->role.'/profile');
            }
        }

        $countries=$this->appsCountry->all();

        return view('web.mangopay.index',compact('countries','user'));
    }

    public function createUserWallet(Request $request){ 
      
      	$request->validate([
			'FirstName'=>'required',
			'LastName'=>'required',
			'AddressLine1'=>'required',
			//   'AddressLine2'=>'required',
			'City'=>'required',
			'Region'=>'required',
			'PostalCode'=>'required',
			'Country'=>'required',
			'Birthday'=>'required',
			// 'Nationality'=>'required',
			// 'CountryOfResidence'=>'required',
			'Occupation'=>'required',
			'IncomeRange'=>'required',
			'Email'=>'required'
      	]);
      
        $token=$this->token();            
        //echo $token;die();
        $inputs = $request->all();

        if(!$token){
            return redirect()->back()->with(['error','Error while generating token for payment.']);
        }
        // echo "<pre>";
        // print_r($inputs);die();

        $inputs['Nationality'] = $request->Country;
        $inputs['CountryOfResidence'] = $request->Country;
        $mangoPayUser=$this->createMangoPayUser($token->access_token,$inputs); 
        $redirectTo = self::getRedirectTo();
        
        if(Auth::guard('admin')->check()){
            $loggedInUser=Auth::guard('admin')->user();
            $role='admin';
        }else{
            $loggedInUser=Auth::user();
            $role = $loggedInUser->role;
        }

        $mangopayWallet=$this->createWallet($token->access_token,$mangoPayUser->Id,$role);

        
        if(!isset($mangopayWallet->errors)){
            if($role=='admin'){
                $walletinfoSave= $this->mangopayAccount->create([
                    'admin_id'=>$loggedInUser->id,
                    'user_id'=>0,
                    'mangopay_user_id'=>$mangoPayUser->Id,
                    'mangopay_wallet_id'=>$mangopayWallet->Id
                ]);
            }else{
                $walletinfoSave= $this->mangopayAccount->create([
                    'admin_id'=>0,
                    'user_id'=>$loggedInUser->id,
                    'mangopay_user_id'=>$mangoPayUser->Id,
                    'mangopay_wallet_id'=>$mangopayWallet->Id
                ]);
            }
            
            return redirect($redirectTo)->with(['success','Wallet created successfully.']);
        }
        else{
            return redirect()->back()->with(['error','Error in creating wallet']);
        } 
    }

    public function addCard(Request $request){
        $token=$this->token();
        $loggedInUser=Auth::user();
        $cardregistrtion=$this->cardReigstration($token->access_token, $loggedInUser->mangopayUser->mangopay_user_id);
        return view('web.mangopay.add_card',compact('cardregistrtion'));
    }

    public function saveCard(Request $request){

        $user=\Auth::user();
        $token=$this->token();
        $card = $this->upadateCard($token->access_token,$request->card_id,$request->card_token);
        
        $this->saveUserCard->undefaultAllCard($user->id);
        $this->saveUserCard->create([
            'user_id'=>$user->id,
            'mangopay_account_id'=> $user->mangopayUser->id,
            'is_default'=>1,
            'card_id'=>$card->CardId
        ]);

        $backUrl = url($user->role.'/profile');
        if($card){
            if(is_array($card)){
                $card['backUrl'] = $backUrl;
               
            }else{
                $card->backUrl = $backUrl;
            }
            $cardData = $this->viewACard($token->access_token,$card->CardId);
            
            $mailData = [];
            $mailData['name'] = $user->first_name;
            $mailData['digits'] = isset($cardData->Alias) ? $cardData->Alias : '**********';
            Mail::to($user->email)->send(new CardAdded($mailData));
        }
        return response()->json($card);
        //  $cardregistrtion=$this->cardReigstration($token->access_token);
        //  dd($cardregistrtion->CardRegistrationURL,$cardregistrtion->AccessKey,$cardregistrtion->PreregistrationData);
        //  dd($cardregistrtion,$this->addMangoCard($cardregistrtion->CardRegistrationURL,$cardregistrtion->AccessKey,$cardregistrtion->PreregistrationData));
    }

    public function paymentTemplate(Request $request){
        return view('web.mangopay.payment-template');
    }

    public function addPaymentToWallet(Request $request){
        return view('web.mangopay.add_payment');
    }

    public function createPaymentLink(Request $request){
        // dd("dfdf");
        $currentUser=Auth::user();

        if(!is_null($currentUser->mangopayUser)){
            $token=$this->token();
            // dd( $token);
            //   $token=$this->token();
            //  dd($token,$currentUser->mangopayUser->mangopay_user_id);
            $paymentlink=$this->addPaymentToMangoWallet( $token->access_token,$currentUser->mangopayUser->mangopay_user_id,$currentUser->mangopayUser->mangopay_wallet_id,$request->amount,$request->card_type);
            // dd( $paymentlink);
            if(isset($paymentlink->RedirectURL)){
                return redirect($paymentlink->RedirectURL);
            }
            else{
                return redirect()->back()->with(['error'=>$paymentlink]);
            }
        }
    }

    public function thanks(){
        return view('web.mangopay.thanks');
    }

    public function setDefaultCard(Request $request){
       // dd($request->all());
        $user=\Auth::user();
        $card=$this->saveUserCard->checkCard($request->cardId,$user->id);
        $this->saveUserCard->undefaultAllCard($user->id);
        if(is_null($card)){
          $this->saveUserCard->create([
            'user_id'=>$user->id,
            'mangopay_account_id'=> $user->mangopayUser->id,
            'is_default'=>1,
            'card_id'=>$request->cardId
          ]);
        }else{
          $card->is_default=1;
          $card->save();
        }
        dd($card);
    }

    // return view to add bank account
    public function addBank(Request $request){
        if(Auth::guard('admin')->check()){
            $user=Auth::guard('admin')->user();
            $role='admin';
        }else{
            $user=Auth::user();
            $role = $user->role;
        }

        if(is_null($user->mangopayUser)){
            $redirect = self::getRedirectTo();
            return redirect($redirect);
        }
        $bankAcType=[
            'IBAN',
            'US',
            'CA',
            'GB',
            'OTHER'
        ];
        $countries=$this->appsCountry->all();

        return view('web.mangopay.add_bank',compact('countries','bankAcType','user'));
    }

    // save user's bank account details
    public function saveBankdetail(Request $request){
        if(Auth::guard('admin')->check()){
            $currentUser=Auth::guard('admin')->user();
            $role='admin';
        }else{
            $currentUser=Auth::user();
            $role = $currentUser->role;
        }
        try{
            if(!is_null($currentUser->mangopayUser))
            {
                $token=$this->token();
                $data['Tag']=$request->Tag;
                $data['OwnerAddress']=[
                    'AddressLine1'=>$request->AddressLine1,
                    "AddressLine2"=>$request->AddressLine2,
                    "City"=> $request->City,
                    "Region"=>$request->Region,
                    "PostalCode"=>$request->PostalCode,
                    "Country"=>$request->Country,
                ];
                if($role!='admin'){
                    $currentUser->address = $request->AddressLine1.','.$request->AddressLine2.','.$request->City.','.$request->Region.','.$request->PostalCode.','.$request->Country;
                    $currentUser->save();
                }
                

                $data['OwnerName']=$request->OwnerName;
                switch($request->BankAccountType){
                   case 'IBAN':
                    $data['IBAN']=$request->IBAN;
                    $data['BIC']=$request->BIC;
                    break;
                  case 'US':
                    $data['AccountNumber']=$request->AccountNumber;
                    $data['ABA']=$request->ABA;
                    $data['DepositAccountType']=$request->DepositAccountType;
                    break;
                  case 'CA':
                    $data['BranchCode']=$request->BranchCode;
                    $data['InstitutionNumber']=$request->InstitutionNumber;
                    $data['AccountNumber']=$request->AccountNumber;
                    $data['BankName']=$request->BankName;
                    break;  
                  case 'GB':
                    $data['SortCode']=$request->SortCode;
                    $data['AccountNumber']=$request->AccountNumber;
                    break;  
                  default:
                    $data['BIC']=$request->BIC;
                    $data['AccountNumber']=$request->AccountNumber;
                    $data['Country']=$request->Country;
                    break; 
                }
                //   dd($data);
                $bankAccount=$this->createBankAccount($token->access_token,$currentUser->mangopayUser->mangopay_user_id,strtolower($request->BankAccountType),$data);
                if(!isset($bankAccount->errors))
                {
                    if($role=='admin'){
                        $this->bankAccount->create([
                            'admin_id'=>$currentUser->id,
                            'user_id'=>0,
                            'mangopay_account_id'=> $currentUser->mangopayUser->id,
                            'is_default'=>0,
                            'bank_id'=>$bankAccount->Id,
                            'response'=>json_encode($bankAccount)
                        ]);
                    }else{
                        $this->bankAccount->create([
                            'user_id'=>$currentUser->id,
                            'admin_id'=>0,
                            'mangopay_account_id'=> $currentUser->mangopayUser->id,
                            'is_default'=>0,
                            'bank_id'=>$bankAccount->Id,
                            'response'=>json_encode($bankAccount)
                        ]);
                    }
                    $redirectTo = self::getRedirectTo();
                    return redirect($redirectTo)->with(['success'=>'Bank added successfully']);
                }
                
                return redirect()->back()->with(['error'=>isset($bankAccount->Message) ? $bankAccount->Message : 'Error while adding Bank account.']);
            }
            return redirect()->back()->with(['error'=>'User Account not found.']);
        }
        catch(\Exception $e){
            return redirect()->back()->with(['error'=>$e->getMessage()]);
        }
    }

    // return view to upload kyc documents
    public function kycDoc(Request $request){
        $doc_type=['IDENTITY_PROOF','REGISTRATION_PROOF','ARTICLES_OF_ASSOCIATION','SHAREHOLDER_DECLARATION','ADDRESS_PROOF'];
        return view('web.mangopay.kyc-doc',compact('doc_type'));
    }    

    // update kyc
    public function uploadKycDoc(Request $request){

        $messages = [
                  'file.required' => 'file name is required.',
                  'document_type.required' => 'Document type  is required.',
                  
              ];

              $validator = Validator::make($request->all(), [
                 
                  'file' => 'required|mimes:jpeg,png,jpg,doc,pdf,docx',
                  'document_type'=>'required',
                 
              ], $messages);
        
              if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
              } else {    

        if(Auth::guard('admin')->check()){
            $currentUser=Auth::guard('admin')->user();
            $role='admin';
        }else{
            $currentUser=Auth::user();
            $role = $currentUser->role;
        }

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName=$this->uploadGalery($image);
          
            $data = base64_encode(file_get_contents(public_path(env('FILE_UPLOAD_PATH').'/'.$imageName)));
            $token=$this->token();
            $docType=$this->createKycDoc($token->access_token,$currentUser->mangopayUser->mangopay_user_id,$request->document_type);
            $abd=$this->createKycPage($token->access_token,$currentUser->mangopayUser->mangopay_user_id,$docType->Id,$data);
            if(is_null($abd)){
                $response=$this->submitKycDoc($token->access_token,$currentUser->mangopayUser->mangopay_user_id,$docType->Id);
                //  dd(env('APP_URL').'/'.env('FILE_UPLOAD_PATH').'/'.$imageName,$data);
                // return redirect()->back()->with(['success'=>'Kyc Document uploaded successfully']);
                $redirectTo = self::getRedirectTo();

                return redirect($redirectTo)->with(['success'=>'Kyc Document uploaded successfully']);
            }
            else{
                return redirect()->back()->with(['error'=>$abd->Message]);
            }
        }
        return redirect()->back()->with(['error'=>"file not attached"]);
    }
    }


    public function createPayoutToBank(Request $request){
        $currentUser=Auth::user();
   
        if(!is_null($currentUser->mangopayUser) && count($currentUser->bankAccount)>0){
            $token=$this->token();
            $walletInfo=$this->veiwWallet( $token->access_token,$currentUser->mangopayUser->mangopay_wallet_id);
            $data=[
              'mangopay_user_id' => $currentUser->mangopayUser->mangopay_user_id,
              'amount' => $walletInfo->Balance->Amount,
              'bank_id' =>$currentUser->bankAccount[0]->bank_id,
              'wallet_id' => $currentUser->mangopayUser->mangopay_wallet_id,
            ];
            $payout=$this->createPayOut($token->access_token,$data);  
            if($payout->Status !='FAILED'){     
                $this->bankPayout->createBankPayout([
                    'user_id'=>$currentUser->id,
                    'bank_account_id'=>$currentUser->bankAccount[0]->id,
                    'payout_id'=>$payout->Id,
                    'response'=>json_encode($payout),
                    'amount'=> $walletInfo->Balance->Amount/100,
                    'status'=>$payout->Status
                ]);
                return redirect()->back()->with(['success'=>"Payout Request created successfully"]);
            }else
            {
                return redirect()->back()->with(['error'=>$payout->ResultMessage]);
            }
        }
    }

    public function payoutList(Request $request){
        $currentUser=Auth::user();
        //dd($currentUser->bankPayout);
        // $token=$this->token();
        // dd($this->viewPayout( $token->access_token,80419942));
        return view('web.mangopay.list-payout',compact('currentUser'));
    }
}
