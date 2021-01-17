<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProjectMessageEvent  implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    protected $project_id;
    protected $toder_id;
    protected $message;
    public function __construct($project_id,$toder_id,$message)
    {
       // dd($project_id,$toder_id,$message);
        $this->project_id=$project_id;
        $this->toder_id=$toder_id;
        $this->message = $message;
        $this->dontBroadcastToCurrentUser();

       
    }
   

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
       // dd($this->project_id);
     //  return new Channel('message');
       return new Channel('Project.'.$this->project_id.'.'.$this->toder_id);
    }
    public function broadcastWith()
    {
        return ['message' =>$this->message];
    }
   
}
