<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailUpdateAdv extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($data)
    {
        $this->signup_mail_data = $data;
    }

    public function build()
    {
        return $this->from('foxzaro1@gmail.com', 'coder')->subject('new update price!')->view('mail.testmail', ['mail_data' => $this->signup_mail_data]);
    }
}