<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use Illuminate\Support\Facades\Auth;
class FaqController extends Controller
{
    use \App\Traits\CommonUtil;

    public $permissionName;
    public function __construct(){
        $this->permissionName = 'faq_management_access';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $data = Faq::orderBy('id','asc')->get();
        $user=Auth::guard('admin')->user();
        return view('admin.faqs.index', ['data'=>$data,'user'=>$user]);
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
        return view('admin.faqs.create', ['title' => 'create FAQ','user'=>$user]);
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
            'category'=>'bail|required|string|max:100',
            'title'=>'bail|required|string|max:100',
            'content'=>'bail|required|string|max:5000'
        ]);
        $couponCreated=Faq::create([
            'category'=>$request->category,
            'title'=>$request->title,
            'content'=>$request->content,
        ]);

        return redirect()->route('faqs.index')->with(['success'=>'FAQ created successfully']);
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
        $data = Faq::where('id', $id)->firstOrFail();
        $user=Auth::guard('admin')->user();
        return view('admin.faqs.edit', ['title' => 'Edit FAQ','user'=>$user,'data'=>$data]);
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
        $request->validate(
            [
                'category'=>['bail','required','max:100'],
                'title'=>['bail','required','max:100'],
                'content'=>'bail|required|min:10|max:5000',
            ]
        );

        $data = Faq::where('id', $id)->first();
        if(!$data){
            return redirect()->back()->with(['error'=>'Record not found. Please try again later']);
        }

        $data->category = $request->category;
        $data->title = $request->title;
        $data->content = $request->content;

        if($data->save()){
            return redirect()->route('faqs.index')->with(['success'=>'FAQ updated successfully']);
        }else{
            return redirect()->route('faqs.index')->with(['error'=>'FAQ not updated. Please try again later.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_unless($this->helperCheckPermission($this->permissionName), 403);
        $data = Faq::where('id', $id)->first();
        if(!$data){
            return response()->json(['status'=>false,'message'=>'Record not found. Please try again later'],200);
        }

        if($data->delete()){
            return response()->json(['status'=>true,'message'=>'Record deleted successfully.'],200);
        }else{
            return response()->json(['status'=>false,'message'=>'Record not deleted. Please try again later'],200);
        }

    }
}
