<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TimeSheetApproved extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
  
    private $user;
    private $type;
    public function __construct($user, $type)
    {
        $this->user=$user;
        $this->type=$type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->type==1){
            return $this->view('EmailTemplate.time_sheet_approved')->subject('Timesheet Approved')->with(['user'=>$this->user]);
        }
        else{
            return $this->view('EmailTemplate.time_sheet_rejected')->subject('Timesheet Rejected')->with(['user'=>$this->user]);
        } 
    }
}
