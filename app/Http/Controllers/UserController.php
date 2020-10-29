<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Action\Record;
use App\Services\Action\RecordUser;
use App\Services\Action\RecordAdvert;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public $url;
    public $email;

    public function get_data(Request $request)
    {
        (new Record($request))->init();
    }

    public function verify(Request $request)
    {
        if ((new User())->doVerificatonFromEmail($request->code)) {
            return view('include.success-page');
        } else {
            return view('include.fail-page');
        }
    }
}

