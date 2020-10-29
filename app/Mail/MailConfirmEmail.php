<?php

namespace App\Mail;

use Illuminate\Support\Facades\URL;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailConfirmEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct($data)
    {
        $this->signup_mail_data = $data;
    }

    public function build()
    {
        return $this->from('foxzaro1@gmail.com', 'site')->subject('Please, confirm your Email!')->view(
            'mail.confirm_email',
            [
                'mail_data' => $this->signup_mail_data,
                'url' => URL::to('/') . "/verify/" . $this->signup_mail_data['code']
            ]
        );
    }
}
