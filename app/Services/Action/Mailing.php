<?php

namespace App\Services\Action;

use App\Models\Advert;
use Illuminate\Support\Facades\Mail;
use DB;
use App\Mail\MailUpdateAdv;


/**
 * Class Mailing
 *
 * @package App\Services\Action
 */
class Mailing
{
    private $advInfo = [];

    /**
     * Mailing constructor.
     * @param array $advInfo
     */
    public function __construct(array $advInfo)
    {
        $this->advInfo = $advInfo;
    }

    public function init()
    {
        $users = Advert::find($this->advInfo['id']);
        $users = $users->users;

        if ($users->count() > 0) {
            foreach ($users as $key => $value) {
                $this->sendEmail($value->email);
            }
        }
    }

    /**
     * Send email to user
     *
     * @param $email
     *
     */
    private function sendEmail($email)
    {
        $data = [
            'adv' => $this->advInfo['adv'],
            'price' => $this->advInfo['price'],
            'url' => $this->advInfo['url'],
            'email' => $email,
        ];
        Mail::to($email)->send(new MailUpdateAdv($data));
    }
}
