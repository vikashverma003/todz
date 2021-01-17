<?php namespace App\Repositories;

use App\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Auth;
use DB;
class UserRepository implements UserRepositoryInterface
{
    
    public function all(){

    }
    public function create(array $data){
        return User::create([
            'first_name'        =>$data['first_name'],
            'last_name'         =>$data['last_name']??'',
            'email'             =>$data['email']??null, 
            'password'          =>\Hash::make($data['password']),
            'phone_code'        =>$data['phone_code']??null,
            'phone_number'      =>$data['phone_number']??null,
            'account_status'    =>config('constants.account_status.ACTIVE'),
            'role'              =>$data['role'],
            'facebook_id'       =>$data['facebook_id']??null,
            'linkedin_id'       =>$data['linkedin_id']??null,
            'registration_step' =>$data['registration_step']??1,
            'entity'            =>$data['entity']??'',
            'company_name'      =>$data['company_name']??'',
            'description'       =>$data['description']??'',
            'no_of_employees'   =>$data['no_of_employees'] ?? 0,
            'coupon'            =>$data['coupon']??null,
            'coupon_id'         =>$data['coupon_id']??null,
            'location'=>$data['location']??null,
            'company_address'=>$data['company_address']??null,
            'registration_number'=>$data['registration_number']??null,
            'vat_details'=>$data['vat_details']??null,
            'country'=>$data['country']??null,
            'expected_hourly_rate'=>$data['expected_hourly_rate'] ?? 0,
            
        ]);
    }
    public function update(array $data, $id){

    }
    public function delete($id){
        $user=User::where('id',$id)->first();
        $user->first_name= $user->id.''.str_repeat( "x", strlen(  $user->first_name) );
        $user->email=$user->id.''.str_repeat( "x", strlen(  $user->email) );
        $user->phone_number=$user->id.''.str_repeat( "x", strlen(  $user->phone_number) );
        $user->save();

        return User::where('id',$id)->delete();
    }
    public function show($id){

    }
    public function checkUserByEmail($email)
    {
        return User::where('email',$email)->first();
    }
    public function updateToken($tkn,$id)
    {
        return User::where('id',$id)->update([
            'email_token' => $tkn
        ]);
    }
    public function getUserById($id)
    {
        return User::where('id',$id)->first();
    }
    public function getUserByToken($tkn)
    {
        return User::where('email_token',$tkn)->first();
    }
    public function resetPassword($data)
    {
        return User::where('email_token',$data['email_token'])->update([
            'password'  => \Hash::make($data['password']),
            'email_token' => null
        ]);
    }

    public function getCurrentUser(){
       return Auth::user();
    }

    public function getTalents($exclude=null,$perPage=10){
        $userss=User::where('role',config('constants.role.TALENT'));
        if(!is_null($exclude)){
            $userss=$userss->whereNotIn('id',$exclude);
        }
        return  $userss->where('account_status',config('constants.account_status.ACTIVE'))->where('registration_step',3)->testcomplete()->get();
    }

    public function getByTodzId($todz_id){
        return User::where('todz_id',$todz_id)->first();
    }

    public function countByRole($roleName){
        $usr= User::where('role',$roleName);
        if($roleName==config('constants.role.CLIENT')){
            $usr->where('registration_step',2);
        }else{
            $usr->where('registration_step',3);
        }
        return $usr->count();
        }

   
        public function getUserByMonthWise($roleName){
           $usr=User::select(DB::raw("count(*) as total"),DB::raw("MONTH(created_at) as Month"))->where('role',$roleName)->groupBy(DB::raw("MONTH(created_at)"));
            if($roleName==config('constants.role.CLIENT')){
                $usr->where('registration_step',2);
            }else{
                $usr->where('registration_step',3);
            }
            return $usr->get();
        }
   public function getUserByRole($roleName,$perpage=10){
        $usr= User::where('role',$roleName);
            if($roleName==config('constants.role.CLIENT')){
                $usr->where('registration_step',2);
            }else{
                $usr->where('registration_step',3);
            }
           
            return  $usr->orderBy('id','desc')->paginate($perpage);
        }  
    public function blockUser($talent_id)
    {
        return User::where('id',$talent_id)->update([
            'block' => new \DateTime
        ]);
    }  
}