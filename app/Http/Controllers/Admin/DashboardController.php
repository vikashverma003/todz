<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use DB;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\Interfaces\ProjectPaymentRepositoryInterface;
use App\Models\AdminRevenue;
class DashboardController extends Controller
{
    public function __construct(UserRepositoryInterface $user,ProjectRepositoryInterface $project,
    ProjectPaymentRepositoryInterface $projectPayment,AdminRevenue $adminRevenue){
        $this->user=$user;
        $this->project=$project;
        $this->projectPayment=$projectPayment;
        $this->adminRevenue=$adminRevenue;
    }

    public function index(){
      $isShow=1;
      if(isset($_GET['projectShow'])){
        $isShow=$_GET['projectShow'];
    }
    $revenueShow=1;
    if(isset($_GET['revenueShow'])){
      $revenueShow=$_GET['revenueShow'];
  }
        $user=Auth::guard('admin')->user();
        $client = $this->user->countByRole(config('constants.role.CLIENT'));
        $talents = $this->user->countByRole(config('constants.role.TALENT'));
        $projectsCount=$this->project->getTotalProjectPosted($isShow);
        $projectTotalRevenue= $this->adminRevenue->getTotalRevenue($revenueShow);
       $usersGraph=$this->graphState();
       $projectAnalitics=$this->postedProjectPieChart($isShow);
       $adminRevenueBarChart=$this->adminRevenueBarChart($revenueShow);
       $getRevenueYear=$this->adminRevenue->getRevenueYear();
             // echo $getRevenueYear;die();

        return view('admin.dashboard', ['title' => 'Dashboard','user'=>$user,'client'=>$client,'talents'=>$talents,'usersGraph'=>$usersGraph,'projectsCount'=>$projectsCount,'projectTotalRevenue'=>$projectTotalRevenue,
        'projectAnalitics'=> $projectAnalitics,
        'adminRevenueBarChart'=>$adminRevenueBarChart,
        'getRevenueYear'=>$getRevenueYear]);
    }
    private function graphState(){
        $grahpData=[];
        $grahpData[]=[
          'label'=>'Client',
          'data'=> [],
          'backgroundColor'=> [
            'rgba(255, 180, 99,0.2)',
           ],
          'borderColor'=> [
            'rgba(255, 180, 99,1)'
          ],
          'borderWidth'=> 2,
          
        ];
        $data=[0,0,0,0, 0, 0,0,0,0,0,0,0];
        $f=$this->user->getUserByMonthWise(config('constants.role.CLIENT'));
        if(sizeOf($f)>0){
            foreach($f as $v){
                $data[$v->Month-1]=(int) $v->total;
            }
        }
        $grahpData[0]['data']=$data;
        
        
        $grahpData[]=[
          'label'=>'Talents',
          'data'=> [],
          'backgroundColor'=> [
            'rgb(0, 194, 146,0.2)',
           ],
          'borderColor'=> [
            'rgba(0, 194, 146,1)'
          ],
          'borderWidth'=> 2
        ];
        $data=[0,0,0,0, 0, 0,0,0,0,0,0,0];
        $f=$this->user->getUserByMonthWise(config('constants.role.TALENT'));
        if(sizeOf($f)>0){
            foreach($f as $v){
                $data[$v->Month-1]=(int) $v->total;
            }
        }
        $grahpData[1]['data']=$data;
        return $grahpData;
    }

    public function postedProjectPieChart($isShow){
  
    $projectDAta=$this->project->getProjectCountByStatus($isShow);
     $projectLabel=[];
     $projectCount=[];
     foreach($projectDAta as $key=>$value){
      $projectLabel[]=$value->status;
      $projectCount[]=$value->total;
     }
    
    $data['projectLabel']= count($projectLabel)>0?$projectLabel:['no Project'];
    $data['projectCount']= count($projectCount)>0?$projectCount:[0];

    return json_encode($data);
    }

    public function adminRevenueBarChart($revenueShow){
      if($revenueShow>1){
      $projectLabel=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aus','Sep','Oct','Nov','Dec'];
      $projectCount=[0,0,0,0,0,0,0,0,0,0,0,0];
      $projectDAta=$this->adminRevenue->getCountforGraph($revenueShow);
      foreach($projectDAta as $key=>$value){
        $projectCount[$value->status-1]=$value->total;
       }
       $data['projectLabel']= count($projectLabel)>0?$projectLabel:['2018','2019','2020'];
       $data['projectCount']= count($projectCount)>0?$projectCount:[0,0,0];
       return json_encode($data);
      }
      $projectLabel=[];
     $projectCount=[];
     $projectDAta=$this->adminRevenue->getCountforGraph($revenueShow);
     foreach($projectDAta as $key=>$value){
      $projectLabel[]=$value->status;
      $projectCount[]=$value->total;
     }
     $data['projectLabel']= count($projectLabel)>0?$projectLabel:['2018','2019','2020'];
    $data['projectCount']= count($projectCount)>0?$projectCount:[0,0,0];
    // echo "<pre>";
    // print_r($data);die();

    return json_encode($data);
    }
}
