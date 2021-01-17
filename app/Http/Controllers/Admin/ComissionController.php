<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminComission;

class ComissionController extends Controller
{
   private $comission;
    public function __construct(AdminComission $comission){
        $this->comission=$comission;
    }
    public function index()
    {
        $user=Auth::guard('admin')->user();
        $com = $this->comission->getComission();

        return view('admin.comission.index', ['title' => 'Comission & Charges','user'=>$user,'com'=>$com]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_comission'=>'bail|required|numeric|min:0',
            'payment_gateway_fee'=>'bail|required|numeric|min:0',
            'vat'=>'bail|required|numeric|min:0',
            'vat_number'=>'bail|required|string',
        ]);
        $com = $this->comission->getComission();
        if(!is_null($com)){
            $update = $this->comission->updateComission($com->id,$request->project_comission, $request->payment_gateway_fee, $request->vat, $request->vat_number);
            return redirect()->route('comission.index')->with(['success'=>'Project Comission updated successfully']);
        }
        
        $create = $this->comission->createComission($request->project_comission, $request->payment_gateway_fee, $request->vat, $request->vat_number);
        return redirect()->route('comission.index')->with(['success'=>'Project Comission created successfully']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
        //
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
        //
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
