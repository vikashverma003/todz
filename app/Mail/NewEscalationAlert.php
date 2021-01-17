<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewEscalationAlert extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $data;
    private $type;
    public function __construct($data, $type)
    {
        $this->data=$data;
        $this->type=$type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        if($this->type==1){
            return  $this->view('EmailTemplate.newEscalationAlertToAdmin',[
                'data'=>  $this->data
            ]);
        }

        return  $this->view('EmailTemplate.newEscalationAlertToTalent',[
            'data'=>  $this->data
        ]);
    }
}
