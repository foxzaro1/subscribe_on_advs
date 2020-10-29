<?php

namespace App\Services\Action;

use App\Jobs\ProcessSendingEmail;
use App\Mail\MailConfirmEmail;
use App\Mail\MailUpdateAdv;
use App\Models\Advert;
use Illuminate\Support\Facades\Mail;

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
                if ($value->active) {
                    $this->advInfo['email'] = $value->email;
                    dispatch((new ProcessSendingEmail($this->advInfo))->delay(120));
                }
            }
        }
    }

    /**
     * Send email to user, update price advert
     *
     * @param $email
     *
     */
    public function sendEmailAdvUpdated($arr)
    {
        $data = [
            'adv' => $arr['adv'],
            'price' => $arr['price'],
            'url' => $arr['url'],
            'email' => $arr['email'],
        ];
        Mail::to($data['email'])->send(new MailUpdateAdv($data));
    }

    /**
     * Send email to user, verify account
     *
     * @param $arr
     */
    public function sendEmailVerifyCode($arr)
    {
        $data = [
            'email' => $arr['email'],
            'code' => $arr['code'],
        ];
        Mail::to($data['email'])->send(new MailConfirmEmail($data));
    }

}
