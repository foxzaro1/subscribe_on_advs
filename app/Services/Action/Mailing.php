<?php
namespace App\Services\Action;

use Illuminate\Support\Facades\Mail;
use DB;
use App\Mail\MailUpdateAdv;
use App\Models\Users;
class Mailing
{
    private $advInfo = [];
    public function __construct(array $advInfo){
        $this->advInfo = $advInfo;
    }


    public function init(){
        $listEmails = [];
        $users = DB::table('users')->whereJsonContains('advertIds', [$this->advInfo['id']])->get();
        if($users->count() > 0) {
            foreach ($users as $key => $value) {
                $this->sendEmail($value->email);
            }
        }
    }
    private function sendEmail($email){
        $data = [
            'adv' => $this->advInfo['adv'],
            'price' => $this->advInfo['price'],
            'url' => $this->advInfo['url'],
            'email' => $email,
        ];
        Mail::to($email)->send(new MailUpdateAdv($data));
    }
}
