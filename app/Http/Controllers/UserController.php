<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Advert;
use App\Services\Action\Record;
use App\Services\Action\RecordUser;
use App\Services\Action\RecordAdvert;
use Illuminate\Http\Request;
use Symfony\Component\HttpClient\HttpClient;

class UserController extends Controller
{
    public $url;
    public $email;

    public function get_data(Request $request)
    {
        (new Record($request))->init();
    }
}

