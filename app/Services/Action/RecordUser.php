<?php
namespace App\Services\Action;

use App\Models\User;

class RecordUser
{
    private $email;

    public function __construct(string $email){
        $this->email = $email;
    }

    public function init(){
       return $this->checkUser();
    }

    private function checkUser(){
        return (User::where('email', '=', $this->email)->first() == null) ?  $this->addUser() : User::where('email', '=', $this->email)->first();
    }

    private function addUser(){
        $user = new User;
        $user->email = $this->email;
        return $user;
    }

}
