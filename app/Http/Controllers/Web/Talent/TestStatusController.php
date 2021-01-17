<?php

namespace App\Http\Controllers\Web\Talent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Repositories\Interfaces\TalentRepositoryInterface;


class TestStatusController extends Controller
{
    private $user;
    public function __construct(UserRepositoryInterface $user,
    NotificationRepositoryInterface $notification, TalentRepositoryInterface $talent){
        $this->user=$user;
        $this->notification=$notification;
        $this->talent = $talent;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $currentUser=$this->user->getCurrentUser();
        if($request->has('is_read')){
            $user=\Auth::user();
            $this->notification->readMark($user->id,$request->is_read);
        }
        return view('web.talents.testStatus.index',compact('currentUser'));
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
    public function talentHourApproval(Request $request)
    {
        $currentUser=$this->user->getCurrentUser();
        if($request->action == 'Accept')
        {
            $status = config('constants.hours.APPROVED');
        }
        else
        {
         $status = config('constants.hours.DECLINED');   
        }
        $update = $this->talent->updateUserHoursApproval($currentUser->id,$status);
        if($update)
        {
            return back()->with('success',1);
        }
        return back()->with('success',0);
    }
}
