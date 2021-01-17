<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Skill;

class SkillController extends Controller
{
    use \App\Traits\CommonUtil;

    public $permissionName;
    private $skill;
    public function __construct(Skill $skill){
        $this->skill=$skill;
        $this->permissionName = 'skills_management_access';
    }

    public function index()
    {
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $user=Auth::guard('admin')->user();
        $skills=$this->skill->getAll();
        return view('admin.skills.index', ['title' => 'Project Services','user'=>$user,'skills'=>$skills]);
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
        return view('admin.skills.create', ['title' => 'Create Service','user'=>$user]);
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
            'name'  =>  'required'
        ]);
        $skill=$this->skill->createSkill([
            'name'=>$request->name,
        ]);
        return redirect()->route('skills.index')->with(['success'=>'Skill created successfully']);
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
        $skill = $this->skill->getById($id);
        return view('admin.skills.edit', ['title' => 'Edit Service','user'=>$user,'skill'=>$skill]);
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
        ]);
        $update=$this->skill->updateSkill([
            'name'=>$request->name,
        ],$id);

        return redirect()->route('skills.index')->with(['success'=>'Service updated successfully']);
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
