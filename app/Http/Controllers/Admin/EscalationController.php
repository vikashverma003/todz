<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Escalation;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Session;

class EscalationController extends Controller
{
    use \App\Traits\CommonUtil;

    public $permissionName;

    public function __construct( Escalation $escalation, UserRepositoryInterface $user){
        $this->escalationObj = $escalation;
        $this->userObj = $user;
        $this->permissionName = 'escalations_management_access';
    }
    public function index(){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        
        $user=Auth::guard('admin')->user();
        $data = Escalation::orderBy('id','desc')->paginate();
        return view('admin.escalations.index', ['title' => 'Escalations','user'=>$user,'data'=>$data]);
    }

    public function show(Request $request, $id){
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $user=Auth::guard('admin')->user();
        $success = Session::get('success',0);
        $data = Escalation::where('id',$id)->firstOrFail();
        return view('admin.escalations.detail', ['title' => 'Escalation Details','user'=>$user,'data'=>$data,'success'=>$success]);
    }
    public function resolveEsclarationIssue(Request $request)
    {
        abort_unless($this->helperCheckPermission($this->permissionName), 403);

        $data = $request->all();
        $escl = Escalation::where('id',$data['esclaration_id'])->first();
         $update = $this->escalationObj->update_escl($data);
        if($data['in_favour'] == config('constants.role.CLIENT'))
        {
            $block_user = $this->userObj->blockUser($escl->talent_id);
        }
        return back()->with(['success'=>1,'mesage'=>'Issue Resolved Successfully']);

    }

}
