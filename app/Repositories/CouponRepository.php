<?php namespace App\Repositories;

use App\Models\Coupon;
use App\Repositories\Interfaces\CouponRepositoryInterface;

class CouponRepository implements CouponRepositoryInterface
{
    
    public function all(){
       return  Coupon::paginate(10);
    }
    public function create(array $data){
        return  Coupon::create([
            'name'=>$data['name'],
            'code'=>$data['code'],
            'description'=>$data['description']??null,
            'max_redemption'=>$data['max_redemption']??1,
            'expire_date'=>$data['expire_date'] ?? null,
            'price'=>$data['price']??0,
            'discount_type'=>$data['discount_type']??1,
            'coupon_type'=>$data['coupon_type']??1,
            'coupon_value'=>$data['coupon_value']??0,
        ]);
    }
    public function update(array $data, $id){
        return  Coupon::where('id',$id)->update([
            'name'=>$data['name'],
            'code'=>$data['code'],
            'description'=>$data['description']??null,
            'max_redemption'=>$data['max_redemption']??1,
            'expire_date'=>$data['expire_date']??null,
            'price'=>$data['price']??0,
            'discount_type'=>$data['discount_type']??1,
            'coupon_type'=>$data['coupon_type']??1,
            'coupon_value'=>$data['coupon_value']??0,
        ]);
    }
    public function delete($id){

    }
    public function show($id){

    }
    public function getById($id)
    {
        return Coupon::where('id',$id)->first();
    }
    public function checkCoupon($code,$user_type)
    {
        return Coupon::whereIn('coupon_type',[$user_type,config('constants.COUPON_TYPE.BOTH')])->where('code',$code)->first();
    }


}