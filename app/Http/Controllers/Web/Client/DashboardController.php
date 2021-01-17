<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\Interfaces\MessageRepositoryInterface;
use Auth;
use App\Repositories\Interfaces\NotificationRepositoryInterface;

class DashboardController extends Controller
{

    public function __construct(ProjectRepositoryInterface $project,MessageRepositoryInterface $message,NotificationRepositoryInterface $notification){
        $this->project=$project;
        $this->message=$message;
        $this->notification=$notification;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=Auth::user();
        $postedProjects=$this->project->getPostedProject(); // projects which are posted but not (hired and accepted)
        $upcomingProjects = $this->project->getUpcomingProject(); // project which talent accepted but not hired
        
        $activeProjects = $this->project->getActiveProject(); // project in which talent are hired
        $disputedProjects = $this->project->getclientDisputedProjects(); //project which are closed before completion
        $completedProjects = $this->project->getclientCompletedProjects(); //project which are completed
        $activetoder=$this->message->getToderWithProject($user->id);

        return view('web.client.dashboard.index',compact('postedProjects','upcomingProjects','activetoder','activeProjects','disputedProjects','completedProjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
     
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
    function fetch_posted_projects(Request $request)
    {
     if($request->ajax())
     {
      $postedProjects = $this->project->getOwnProject();
      return view('web.client.dashboard.pagination_data', compact('postedProjects'))->render();
     }
    }
}
