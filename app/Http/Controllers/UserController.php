<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Advert;
use App\Services\Action\RecordUser;
use App\Services\Action\RecordAdvert;
use Illuminate\Http\Request;
use Symfony\Component\HttpClient\HttpClient;

class UserController extends Controller
{
    public $url;
    public $email;

    public function __construct(Request $request){
        $this->url = $request->input('url');
        $this->email = $request->input('email');
    }
    public function get_data(){

       try{
            $full_url     = array_filter(explode('/',$this->url));
            $advCode      = end($full_url);
            $recordUser   = new RecordUser($this->email);
            $recordAdvert = new RecordAdvert($advCode);

            $user         = $recordUser->init();
            $advert       = $recordAdvert->init();

            if($advert->url === null) {
                $advert->url = $this->url;
                $advert->save();
            }

            
            if($user->advertIds === null) {
                $user->advertIds = json_encode(array($advert->id));
            }
            else{
                $decodeVersion = json_decode($user->advertIds);
                if(!in_array($advert->id, $decodeVersion)) {
                    array_push($decodeVersion,$advert->id);
                    $user->advertIds = json_encode($decodeVersion);
                }
            }
            $user->save();
        }
        catch(\Exception $e){
             throw new \Exception('Fail scrapping');
        }
    }
}

