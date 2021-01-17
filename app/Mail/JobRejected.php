<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobRejected extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
  
    private $name;
    private $todzid;
    public function __construct($name, $todzid)
    {
        $this->name=$name;
        $this->todzid=$todzid;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('EmailTemplate.job_rejected')->subject('Job Rejected')->with(['name'=>$this->name,'todzid'=>$this->todzid]); 
    }
}
