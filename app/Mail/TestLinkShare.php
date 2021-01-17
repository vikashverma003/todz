<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestLinkShare extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public  $user;
    public $test_link;
    public $subject;
    public function __construct($user,$test_link,$subject)
    {
        $this->user=$user;
        $this->test_link= $test_link;
        $this->subject=$subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject=$this->subject;
        return $this->view('EmailTemplate.test_link_share')
                    ->subject($subject)->with(['user'=>$this->user,'test_link'=>$this->test_link]);
    }
}
