<?php
namespace App\Services\Action;

use App\Models\User;
use App\Models\Advert;
use App\Mail\MailUpdateAdv;
use App\Services\Action\Parse;
use App\Services\Action\Mailing;
use App\Services\Action\RecordUser;
use App\Services\Action\RecordAdvert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpClient\HttpClient;
class Process
{
    public function init(){
       try{
            Advert::chunk(200, function($adverts){
                    foreach ($adverts as $advert)
                    {
                        $parse = new Parse($advert->url);
                        $parse->setParseClass('.js-item-price');
                        if($advert->price === null){
                            $advert->price = $parse->init();
                            $advert->save();
                        }
                        else{
                            $newPrice  = $parse->init();
                            if($newPrice != $advert->price){
                                $advert->price = $newPrice;
                                $advert->save();
                                $mailer = new Mailing(array('price'=>$newPrice,'id'=>$advert->id,'url'=>$advert->url,'adv'=>$advert->advCode));
                                $mailer->init();
                            }
                        }
                    }
                });
        }
        catch(\Exception $e){
             throw new \Exception('Fail Parsing');
        }
    }
}
