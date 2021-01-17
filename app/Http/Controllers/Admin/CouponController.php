<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use Illuminate\Support\Facades\Auth;
class CouponController extends Controller
{
    use \App\Traits\CommonUtil;

    public $permissionName;

    private $coupon;
    public function __construct(CouponRepositoryInterface $coupon){
        $this->coupon=$coupon;
        $this->permissionName = 'coupon_management_access';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $user=Auth::guard('admin')->user();
        $coupons=$this->coupon->all();

        return view('admin.coupon.index', ['title' => 'Coupon Manager','user'=>$user,'coupons'=>$coupons]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $user=Auth::guard('admin')->user();
        return view('admin.coupon.create', ['title' => 'create Coupon','user'=>$user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $request->validate([
            'name'  =>  'required',
           // 'description'   => 'required',
            'coupon_code'   => 'required',
            'coupon_type' => 'required',
            'coupon_value' => 'required'
        ]);
        $couponCreated=$this->coupon->create([
            'name'=>$request->name,
            'code'=>$request->coupon_code,
            'coupon_value' => $request->coupon_value,
            'coupon_type' => $request->coupon_type,
            'description'=>$request->description??null,
        ]);

        return redirect()->route('coupon.index')->with(['success'=>'Coupon created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $user=Auth::guard('admin')->user();
        $coupon = $this->coupon->getById($id);
        return view('admin.coupon.edit', ['title' => 'Edit Coupon','user'=>$user,'coupon'=>$coupon]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $request->validate([
            'name'  =>  'required',
           // 'description'   => 'required',
            'coupon_code'   => 'required',
            'coupon_type' => 'required',
            'coupon_value' => 'required'
        ]);
        $couponCreated=$this->coupon->update([
            'name'=>$request->name,
            'code'=>$request->coupon_code,
            'coupon_value' => $request->coupon_value,
            'coupon_type' => $request->coupon_type,
            'description'=>$request->description??null,
        ],$id);

        return redirect()->route('coupon.index')->with(['success'=>'Coupon updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
