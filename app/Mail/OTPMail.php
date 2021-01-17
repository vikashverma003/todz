<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OTPMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $otp;
    private $name;
    public function __construct($name,$otp)
    {
        $this->name=$name;
        $this->otp=$otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
     //   return $this->view('view.name');
        return  $this->view('EmailTemplate.otp-mail',[
            'otp'=> $this->otp,
            'name'=>  $this->name
        ]);
    }
}
