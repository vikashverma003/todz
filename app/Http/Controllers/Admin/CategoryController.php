<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobCategory;
class CategoryController extends Controller
{
    use \App\Traits\CommonUtil;

    public $permissionName;
    private $category;
    public function __construct(JobCategory $category){
        $this->category=$category;
        $this->permissionName = 'categories_management_access';
    }

    public function index()
    {
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $user=Auth::guard('admin')->user();
        $categories=$this->category->getAll();
        // dd($categories);
        return view('admin.categories.index', ['title' => 'Project Categories','user'=>$user,'categories'=>$categories]);
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
        return view('admin.categories.create', ['title' => 'create Category','user'=>$user]);
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
        $category=$this->category->createCategory([
            'name'=>$request->name,
        ]);
        return redirect()->route('categories.index')->with(['success'=>'Category created successfully']);
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
        $category = $this->category->getById($id);
        return view('admin.categories.edit', ['title' => 'Edit Category','user'=>$user,'category'=>$category]);
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
        $update=$this->category->updateCategory([
            'name'=>$request->name,
        ],$id);

        return redirect()->route('categories.index')->with(['success'=>'Category updated successfully']);
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
