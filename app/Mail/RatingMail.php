<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RatingMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $rating_number;
    private $user;
    public function __construct($rating_number,$user)
    {
        //
        $this->rating_number=$rating_number;
        $this->user=$user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       // return $this->view('view.name');
        //return  $this->view('RatingTemplate.rating1');
         switch ($this->rating_number) {
                    case 1:
                     return  $this->view('RatingTemplate.rating1');
                    break;
                    case 2:
                     return  $this->view('RatingTemplate.rating2');
                    break;
                    case 3:
                     return  $this->view('RatingTemplate.rating3');
                    break;
                    case 4:
                      return  $this->view('RatingTemplate.rating4');
                    break;
                    case 5:
                      return  $this->view('RatingTemplate.rating5');
                    break;
                }

    }
}
