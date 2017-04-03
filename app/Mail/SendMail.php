<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $from_email;
    protected $subject;
    protected $description;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($from_email, $subject, $description)
    {
        $this->from_email = $from_email;
        $this->subject = $subject;
        $this->description = $description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.send-mail')
                    ->from($this->from_email)
                    ->with([
                        'subject' => $this->subject,
                        'description' => $this->description
                    ]);
    }
}
