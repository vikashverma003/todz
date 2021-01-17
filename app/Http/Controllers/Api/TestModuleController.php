<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\TestResultRepositoryInterface;
class TestModuleController extends Controller
{
    public function __construct(TestResultRepositoryInterface $testResult){
        $this->testResult=$testResult;
    }

    public function expertrating_callback(Request $request){

        \Log::info($request->all());
        $data=$request->json()->all();
        foreach($data['request']['method']['parameters'] as $key=>$value){
            $data[$value['name']]=$value['value'];
        }
        $this->testResult->create($data);
        return response()->json(['status'=>'Ok','code'=>'200']);
    }
}
