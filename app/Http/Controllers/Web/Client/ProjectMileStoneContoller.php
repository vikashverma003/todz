<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\Interfaces\MilesloneRepositoryInterface;
use App\Repositories\Interfaces\ProjectPaymentRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Models\AdminComission;
use App\Models\AdminRevenue;
use App\Models\Project;
use App\Models\Mileslone;
use DB;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use App\User;
use Auth;
use App\Mail\TimeSheetApproved;
use App\Mail\MilestoneApproved;
use App\Mail\MilestoneRejected;
use Mail;

class ProjectMileStoneContoller extends Controller
{
	use \App\Traits\CommonUtil;
	use \App\Traits\MangoPayManager;
	
    public function __construct(ProjectRepositoryInterface $project,MilesloneRepositoryInterface $milestone,ProjectPaymentRepositoryInterface $projectPayment,UserRepositoryInterface $user,TransactionRepositoryInterface $transaction,NotificationRepositoryInterface $notification, AdminComission $comission, CouponRepositoryInterface $coupon){
		$this->project=$project;
		$this->milestone=$milestone;
		$this->projectPayment=$projectPayment;
		$this->user=$user;
		$this->transaction = $transaction;
		$this->notification = $notification;
		$this->comission = $comission;
		$this->coupon = $coupon;
	}

	public function updateMilestoneStatus(Request $request)
	{
		$logedInuser=\Auth::user();
		$data = $request->all();
		DB::beginTransaction();

		$milestoneId = $data['id'];
		$milestone = Mileslone::where('id',$milestoneId)->first();
		if(!$milestone){
			return response()->json(['status'=>0,'Message'=>"Milestone record not found."]);
		}
		$project = Project::where('id', $milestone->project_id)->first();
		if(!$project){
			return response()->json(['status'=>0,'Message'=>"Project details not found. Please try again later."]);
		}
		$update = $this->milestone->updateStatus($data);

		$pandingPayment=$this->project->isReleasePayment($data['id']);
		$isPaymentRelease=0;
		$transactionPayment = [];
		$project_talent_user_id = $milestone->talent_user_id ?? false;
		if(!$project_talent_user_id){
			DB::rollback();
			return response()->json(['status'=>0,'Message'=>"Talent Id not found for this project."]);
		}
		$talentUser = $this->user->getUserById($project_talent_user_id);

		if($data['status']==2){
			DB::commit();
			$talent_name = $talentUser->first_name.' '.$talentUser->last_name;
			Mail::to($talentUser->email)->send(new MilestoneRejected($talent_name));
			return response()->json(['status'=>1,'Message'=>"Status updated successfully"]);
		}

		if($pandingPayment['amount']>0)
		{
			$isPaymentRelease = $pandingPayment['amount'];
			
			$token=$this->token();

			// transfer admin cut from client & talent side
			
			
			$adminComissionRate = $this->comission->getComission()->project_comission;
			$amountPaidToTalent = $admin_talent_fee = 0;
			
			$adminMangoPay = $this->getAdminMangoPayAccount();
			$adminUserId = $this->returnAdminUser();

			$finalCommRate = self::applyCouponForTalent($talentUser, $adminComissionRate);
			$finalTalentRate = $finalCommRate['final_comm'];

			// amount release for latent after deduct comm from client
			$admin_talent_fee = (($finalTalentRate*$pandingPayment['amount'])/100);
			$amountPaidToTalent = $pandingPayment['amount'] - $admin_talent_fee;

			$walletInfo=$this->veiwWallet($token->access_token, $logedInuser->mangopayUser->mangopay_wallet_id);
			$walletBalance = isset($walletInfo->Balance->Amount) ? ($walletInfo->Balance->Amount/100) : 0;
			
			$totalPayment = ($amountPaidToTalent+$admin_talent_fee);
			if($walletBalance < $totalPayment)
			{
				return response()->json(['status'=>0,'Message'=>'Wallet balance is low. Please keep atleast $'.$totalPayment.' amount in escrow for this payment. Because pending amount is $'.$pandingPayment['amount'],' and your current balance is'.$walletBalance]);
			}
			

			$walletTransactoin = $this->transferFromWalletToWallet($token->access_token,$logedInuser->mangopayUser->mangopay_user_id,$talentUser->mangopayUser->mangopay_user_id,$logedInuser->mangopayUser->mangopay_wallet_id,$talentUser->mangopayUser->mangopay_wallet_id,$amountPaidToTalent);
			//dd($walletTransactoin);
			
			if(isset($walletTransactoin->Status) && $walletTransactoin->Status=='SUCCEEDED')
			{
				$this->transaction->create([
					'project_id'=>$pandingPayment['project']->id,
					'from_user_id'=>$logedInuser->id,
					'payment_type'=>$walletTransactoin->Type,
					'charge_from_card_id'=>null,
					'to_user_id'=>$talentUser->id,
					'amount'=>$pandingPayment['amount'],
					'fees'=>0,
					'transaction_id'=>$walletTransactoin->Id,
					'response_json'=>$walletTransactoin,
					'coupon_discount'=>$finalCommRate['couponAmount'],
					'transaction_type'=>'talent',
				]);


				// transfer talent's cut from client to admin
				$talentToAdminCommTrans = $this->transferFromWalletToWallet($token->access_token,$logedInuser->mangopayUser->mangopay_user_id, $adminMangoPay->mangopay_user_id,$logedInuser->mangopayUser->mangopay_wallet_id,$adminMangoPay->mangopay_wallet_id,$admin_talent_fee);
			
				if(isset($talentToAdminCommTrans->Status) && $talentToAdminCommTrans->Status=='SUCCEEDED')
				{
					// talent commission entry
					AdminRevenue::create([
						'project_id'=>$pandingPayment['project']->id,
						'from_user_id'=>$logedInuser->id,
						'amount'=>$admin_talent_fee,
						'transaction_id'=>$talentToAdminCommTrans->Id,
						'transaction_response'=>json_encode($talentToAdminCommTrans),
						'commission_from'=>'talent'
					]);
				}else{
					AdminRevenue::create([
						'project_id'=>$pandingPayment['project']->id,
						'from_user_id'=>$logedInuser->id,
						'amount'=>0,
						'transaction_id'=>0,
						'transaction_response'=>$talentToAdminCommTrans ? json_encode($talentToAdminCommTrans) : json_encode(['status'=>'transaction failed']),
						'commission_from'=>'talent'
					]);
				}
				
			}else{
				DB::rollback();
				return response()->json(['status'=>0,'Message'=>$walletTransactoin->ResultMessage ?? 'Transaction failed.','src'=>'clienttalent']);
			}
			$transactionPayment = $this->projectPayment->create([ 
				'project_id'=>$pandingPayment['project']->id,
				'to_user_id'=>$pandingPayment['project']->talent_user_id,
				'amount'=>$pandingPayment['amount'],
				'coupon_discount'=>$finalCommRate['couponAmount'],
				'milestone_id'=>$milestoneId
			]);


			$this->notification->create([
				'to_id'=>$talentUser->id,
				'from_id'=>$logedInuser->id,
				'type'=>config('notifications.notification_type.PAYMENT_ADD_TO_WALLET'),
				'ref'=>$pandingPayment['project']->id,
				'message'=>sprintf(config('notifications.notification_message.PAYMENT_ADD_TO_WALLET'),$pandingPayment['amount'],$pandingPayment['project']->title),
			]);
			$this->notification->create([
				'to_id'=>$logedInuser->id,
				'from_id'=>null,
				'type'=>config('notifications.notification_type.PAYMENT_DEBIT_FROM_WALLET'),
				'ref'=>$pandingPayment['project']->id,
				'message'=>sprintf(config('notifications.notification_message.PAYMENT_DEBIT_FROM_WALLET'),$pandingPayment['amount'],$pandingPayment['project']->title),
			]);
		}
		if($update)
		{
			DB::commit();
			$talent_name = $talentUser->first_name.' '.$talentUser->last_name;
			if($data['status']==1){
				Mail::to($talentUser->email)->send(new MilestoneApproved($talent_name));
			}


			if($isPaymentRelease>0){
				// send milestone invoices to client and todder
				if($transactionPayment){
					self::sendMileStoneInvoiceToClient($pandingPayment['project']->id, $transactionPayment);
					self::sendMileStoneInvoiceToTodder($pandingPayment['project']->id, $transactionPayment);
				}

				return response()->json(['status'=>1,'Message'=>"$".$isPaymentRelease."Payment has been released",'isPaymentRelease'=>$isPaymentRelease]);
			}else{

				return response()->json(['status'=>1,'Message'=>"Status updated successfully",'isPaymentRelease'=>$isPaymentRelease]);
			}
		}
		return response()->json(['status'=>0,'Message'=>"Something Wrong,Please try again later"]);
	}


	/**
	* apply coupon for talent
	**/
	private function applyCouponForTalent($talentUser, $comission){
		$final_comm = $comission;
		$coupon_used = false;
		$couponAmount = 0;
		if($talentUser->coupon_used < 9)
        {
            $coupon_id = $talentUser->coupon_id;
            if($coupon_id){
                $couponDB = $this->coupon->getById($coupon_id);
                if($couponDB)
                {
                    $coupon_value = $couponDB->coupon_value;
                    $final_comm = (($comission*$coupon_value)/100);
                    $coupon_used = true;
                    $couponAmount = $coupon_value;
                    User::where('id', $talentUser->id)->increment('coupon_used');
                }
            }
        }

        return ['coupon_used'=>$coupon_used,'final_comm'=>$final_comm,'couponAmount'=>$couponAmount];
	}

	/**
	* approve/ reject timesheet status. timesheet is created by todder
	**/
	public function updateTimesheetStatus(Request $request){
		$timesheetid = $request->id;
		$status = $request->status;
		$timesheet = \App\Models\Timesheet::where('id', $timesheetid)->first();
		$user = User::where('id', $timesheet->user_id)->first();

		Mail::to($user->email)->send(new TimeSheetApproved($user, $status));

		$timesheet->client_approved = $status;
		$timesheet->save();

		return response()->json(['status'=>true,'message'=>'status updated successfully'], 200);
	}

	/*
	* send mail to client while approving talent's milestone.
	**/
	public function sendMileStoneInvoiceToClient($project_id, $project_payment){
        
			$logedInuser = Auth::user();
            $project = Project::where('id',$project_id)->where('user_id', $logedInuser->id)->first();
	        $admincomission = $this->comission->getComission();
	        $pdf =$this->project->returnClientInvoicePdf($project, $project_payment, $admincomission);
	        
            $email = $logedInuser->email;
            $client_name = $logedInuser->first_name;

            $data["email"]= $email;
            $data["subject"]='Milestone Invoice';
            $data["client_name"]=$client_name;
        try{
            \Mail::send('EmailTemplate.milestone-invoice', $data, function($message)use($data,$pdf) {
                $message->to($data["email"], $data["client_name"])
                ->subject($data["subject"])
                ->attachData($pdf->output(), "Invoice.pdf");
            });
        }catch(\Exception $exception){
            // 
        }
    }

    public function sendMileStoneInvoiceToTodder($project_id, $project_payment){
        $logedInuser = Auth::user();
        $project = Project::where('id',$project_id)->where('user_id', $logedInuser->id)->first();
        $admincomission = $this->comission->getComission();
        
        $talentUser = User::where('id', $project->talent_user_id)->first();

        $pdf =$this->project->returnTalentInvoicePdf($talentUser,$project, $project_payment, $admincomission);
        
        $email = $talentUser->email;
        $client_name = $talentUser->first_name;

        $data["email"]= $email;
        $data["subject"]='Milestone Invoice';
        $data["client_name"]=$client_name;

       	try{
            \Mail::send('EmailTemplate.milestone-invoice', $data, function($message)use($data,$pdf) {
                $message->to($data["email"], $data["client_name"])
                ->subject($data["subject"])
                ->attachData($pdf->output(), "Invoice.pdf");
            });
        }catch(\Exception $exception){
            // 
        }
    }
}
