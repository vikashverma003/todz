<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendInterviewInvite extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$subject,$invitation_link)
    {
        $this->user = $user;
        $this->subject = $subject;
        $this->invitation_link = $invitation_link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject=$this->subject;
        return $this->view('EmailTemplate.send_invitation_link')
                    ->subject($subject)->with(['user'=>$this->user,'invitation_link'=>$this->invitation_link]);
    }
}
