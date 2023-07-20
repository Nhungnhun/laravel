<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\YourMail;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $sendMail;
    protected $userName;

    protected $bookName;
    protected $code;

    public function __construct($sendMail, $userName, $bookName, $code)
    {
        $this->sendMail = $sendMail;
        $this->userName = $userName;
        $this->bookName = $bookName;
        $this->code = $code;
    }

    public function handle()
    {
        $email = new YourMail($this->sendMail, $this->userName, $this->bookName, $this->code);
        Mail::to($this->sendMail)->send($email);
    }
}
