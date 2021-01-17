<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Events\ProjectMessageEvent;
use App\Repositories\Interfaces\MessageRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\ProjectTalent;


class MessageController extends Controller
{

    public function __construct(ProjectRepositoryInterface $project,MessageRepositoryInterface $message,UserRepositoryInterface $user,ProjectTalent $projectTalent){
        $this->project=$project;
        $this->message=$message;
        $this->user=$user;
        $this->projectTalent=$projectTalent;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('web.client.message.index');
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
        $this->validate($request, [
            'message'=>'required',
            'project_id'=>'required|exists:projects,id',
        ]);
      $user=Auth::user();
      $string = app('profanityFilter')->replaceWith('#')->replaceFullWords(false)->filter($request->message);
      $string1=$string;
    preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $string, $matches);
    if(count($matches[0])>0){
        for($i=0;$i<count($matches[0]);$i++){
            $string=$string1;
          $string1=str_replace($matches[0][$i],str_repeat( "x", strlen($matches[0][$i]) ),$string);
    
        }
        }
        $string=$string1;

        preg_match_all('/[0-9]{3}[\-][0-9]{6}|[0-9]{3}[\s][0-9]{6}|[0-9]{3}[\s][0-9]{3}[\s][0-9]{4}|[0-9]{9}|[0-9]{3}[\-][0-9]{3}[\-][0-9]{4}/',$string1, $matches1);
        if(count($matches1[0])>0){
            for($i=0;$i<count($matches1[0]);$i++){
                $string=$string1;
              $string1=str_replace($matches1[0][$i],str_repeat( "x", strlen($matches1[0][$i]) ),$string);
        
            }
            }

     $message= $this->message->create([
        'to_id'=>$request->to_user,
        'from_id'=>$user->id,
       'project_id'=>$request->project_id,
       'message'=>$string1,
      ]);
      $data=['data'=>$message,'timed'=>date('h:i A',strtotime($message->created_at))];
     $redis = \LRedis::connection();
      $redis->publish('Project.'.$request->project_id.'.'.$user->todz_id, json_encode($data));
    //dd(event(new ProjectMessageEvent($request->project_id, $user->todz_id,$request->message)));
   // ProjectMessageEvent::dispatch($request->project_id, $user->todz_id,$request->message);  
    return response()->json(['status'=>'ok','data'=>$message,'timed'=>date('h:i A',strtotime($message->created_at))]);
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

    public function chatScreen($project_id,$todz_id){

        
        $chatuser=$this->user->getByTodzId($todz_id);
        if(is_null($chatuser) || $this->projectTalent->isTelentAcceptedRequest($project_id, $chatuser->id)<1){
            return redirect()->route('client_dashboard');
        }
        $user=\Auth::user();
        $current_project=$this->project->find($project_id,$chatuser->id);

       
        $messages=$this->message->getUserMessage($chatuser->id,$project_id);
        $activetoder=$this->message->getToderWithProject($user->id);
      
     //   $projectsa=$this->message->getChatProject($user->id);
        return view('web.client.message.index',compact('project_id','todz_id','chatuser','messages','activetoder'));
    }

  
}
