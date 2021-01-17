<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Admin;
use App\Models\UserPermission;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Mail\NewAdminAccountMail;
use Mail;
use App\Traits\CommonUtil;

class SubAdminController extends Controller
{

    use CommonUtil;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $permissionName;
    public function __construct(){
        $this->permissionName = 'subadmin_management_access';
    }

    /**
    * return dashboard view of admin side
    */
    public function index(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $title = 'Sub-Admin';
        $user = Auth::guard('admin')->user();
        $inputs = $request->all();
        
        $users = Admin::where('is_super', 0);
        $users = self::filters($users, $inputs, $request);
        $orderby = 'desc';
        if(isset($inputs['orderby'])){
            $orderby = $inputs['orderby'];
        }
        $users = $users->orderBy('id',$orderby)->paginate(10);

        if($request->ajax()){
            return view('admin.sub-admin.list',compact('users'));
        }
        return view('admin.sub-admin.index',compact('users','title','user'));
    }
   
    public function create(Request $request){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $title = 'Add Sub-Admin';
        $user = Auth::guard('admin')->user();
        $permissions = Permission::all();
        return view('admin.sub-admin.create', compact('title','user','permissions'));
    }

    public function edit(Request $request, $id){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $title = 'Edit Sub-Admin';
        $user = Auth::guard('admin')->user();

        $data = Admin::where('is_super', 0)->where('id', $id)->firstOrFail();
        
        $all_permissions= [];
        $all_permissions = Permission::all();
        
        $permissions_id = $data->permissions()->pluck('permission_id')->toArray();
        
        if(!$permissions_id){
            $permissions_id = [];
        }        

        return view('admin.sub-admin.edit',compact('title','user','all_permissions','permissions_id','data'));
    }


    public function store(Request $request){
        $request->validate([
            'first_name'=>'bail|required|string|min:2|max:25',
            'last_name'=>'bail|required|string|min:2|max:25',
            'password'=>'bail|required|string|min:2|max:20',
            'email'=>'bail|required|min:2|max:50|unique:admins,email|email',
            'phone_number'=>'required|unique:admins,phone_number',
            'permissions'=>'bail|required|array',

        ]);
        $data = $request->all();

        $object = new Admin;
        $object->first_name = $request->first_name;
        $object->last_name = $request->last_name;
        $object->phone_number = $request->phone_number;
        $object->phone_code = 0;
        $object->password = Hash::make($request->password);
        $object->account_status = 1;
        $object->is_super = 0;
     //   $object->role = config('constants.role.ADMIN');
        $object->email = strtolower($request->email);
        if($object->save())
        {
            $user_id = $object->id;
            $permissions_data = [];
            foreach ($request->permissions as $key => $value) {
                $permissions_data[] = ['user_id'=>$user_id,'permission_id'=>$value];
            }

            if($permissions_data){
                UserPermission::insert($permissions_data);
            }
            // send email to sub admin after registration.
            Mail::to($request->email)->send(new NewAdminAccountMail($data));

            return response()->json(['status'=>true,'message'=>'Sub-Admin created successfully.','url'=>url('admin/sub-admins')],200);
        }else{
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again'],200);
        }
    }

    public function update(Request $request, $id){
        $request->validate(
            [
                'first_name'=>'bail|required|string|min:2|max:25',
                'last_name'=>'bail|required|string|min:2|max:25',
                'password'=>'bail|nullable|string|min:2|max:20',
                'permissions'=>'bail|required|array',
                'email'=>['bail','required','string','max:50','email', Rule::unique('admins')->ignore($id, 'id')],
                'phone_number'=>['bail','required','string', Rule::unique('admins')->ignore($id, 'id')],
                'status'=>'bail|required|in:0,1'
            ]
        );
        $object = Admin::where('id', $id)->first();
        if(!$object){
            return response()->json(['status'=>false,'message'=>'Record not found. Please try again later'],200);
        }
        $object->first_name = $request->first_name;
        $object->last_name = $request->last_name;
        $object->phone_number = $request->phone_number;
        $object->account_status = $request->status;
        
        if($request->filled('password')){
            $object->password = Hash::make($request->password);
        }
        $object->email = strtolower($request->email);
    
        if($object->save()){
            $permissions_id = $object->permissions()->pluck('permission_id')->toArray();
            $permissions = $request->permissions;
            sort($permissions_id);
            sort($permissions);

            // check if any change in permission then update permission
            if ($permissions_id!=$permissions) {
                UserPermission::where('user_id', $id)->delete();
                $permissions_data = [];
                foreach ($permissions as $key => $value) {
                    $permissions_data[] = ['user_id'=>$id,'permission_id'=>$value];
                }
                if($permissions_data){
                    UserPermission::insert($permissions_data);
                }
            }

            return response()->json(['status'=>true,'message'=>'Sub-Admin updated successfully.','url'=>url('admin/sub-admins')],200);
        }else{
            return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again'],200);
        }
    }

    private function filters($users, $inputs, $request){
    
        if(isset($inputs['name'])){
            $users->where('first_name', 'like', '%' . $inputs['name'] . '%')->orWhere('last_name', 'like', '%' . $inputs['name'] . '%');
        }
        if(isset($inputs['email'])){
            $users->where('email', 'like', '%' . $inputs['email'] . '%');
        }
        if(isset($inputs['status'])){
            $users->where('account_status', (int)$inputs['status']);
        }
        if(isset($inputs['phone'])){
            $users->where('phone_number', 'like', '%' . $inputs['phone'] . '%');
        }
        if($request->filled('start') && $request->filled('end'))
        {
            $date1 = str_replace('/', '-', $request->start);
            $date1 = date('Y-m-d', strtotime($date1));
            $date2 = str_replace('/', '-', $request->end);
            $date2 = date('Y-m-d', strtotime($date2));
            
            $users->whereDate('created_at','>=' ,$date1)->whereDate('created_at','<=' ,$date2);
        }
        elseif ($request->filled('start')) {
            $date = str_replace('/', '-', $request->start);
            $date = date('Y-m-d', strtotime($date));
            $users->whereDate('created_at','>=' ,$date);
        }
        elseif($request->filled('end')){
            $date = str_replace('/', '-', $request->end);
            $date = date('Y-m-d', strtotime($date));
            $users->whereDate('created_at','<=' ,$date);
        }else{}

        return $users;
    }

    public function destroy(Request $request,$id)
    {
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        if(Admin::where('id', $id)->where('is_super', 0)->delete()){
            return response()->json(['status'=>true,'message'=>'User deleted successfully'], 200);
        }
        return response()->json(['status'=>false,'message'=>'Something went wrong. Please try again later'], 200);
    }

    public function export(Request $request){
        return (new \App\Exports\SubAdminExport)->download('subAdmins.xlsx');
    } 

}