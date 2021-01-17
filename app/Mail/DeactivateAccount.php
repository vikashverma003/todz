<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeactivateAccount extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$subject)
    {
            $this->user = $user;
            $this->subject = $subject;    
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject=$this->subject;
        return $this->view('EmailTemplate.account-deactivated')
                    ->subject($subject)->with(['user'=>$this->user]);
    }
}
