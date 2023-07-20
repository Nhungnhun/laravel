<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class YourMail extends Mailable
{
    use Queueable, SerializesModels;
    public $userName;
    public $sendMail;

    public $bookName;
    public $code;

    /**
     * Create a new message instance.
     *
     * @param  string  $userName
     * @param  string  $sendMail
     * @param  string  $bookName
     * @param  string  $code
     * @return void
     */
    public function __construct($sendMail, $userName, $bookName, $code)
    {
        $this->sendMail = $sendMail;
        $this->userName = $userName;
        $this->bookName = $bookName;
        $this->code = $code;
    }
    
    

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Duyệt sách thành công!')
        ->view('emails.email');
    }
}
