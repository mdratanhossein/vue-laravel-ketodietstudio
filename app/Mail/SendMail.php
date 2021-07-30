<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user_email = array();

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_data = array())
    {
        $this->user_email = $user_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.contactus')
                    ->with([
                        'user_data' => $this->user_email,
                    ]);
    }
}
