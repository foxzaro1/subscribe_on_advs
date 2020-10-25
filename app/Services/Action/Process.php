<?php

namespace App\Services\Action;

use Carbon\Carbon;
use App\Models\Advert;
use App\Services\Action\RecordUser;
use App\Services\Action\RecordAdvert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpClient\HttpClient;

/**
 * Class Process
 * @package App\Services\Action
 */
class Process
{
    /**
     * @throws \Exception for bad situation
     */
    public function init()
    {
        try {
            if (Advert::orderBy('id')->where('status', '=', 'wait_update')->count() == 0) {
                $adverts = Advert::all();
                foreach ($adverts as $advert) {
                    $advert->status = 'wait_update';
                    $advert->save();
                }
            }
            Advert::orderBy('id')->where('status', '=', 'wait_update')->chunk(
                20,
                function ($adverts) {
                    foreach ($adverts as $advert) {
                        $parse = new Parse($advert->url);
                        $parse->setParseClass('.js-item-price');
                        $newPrice = $parse->parseElement();
                        if ($newPrice != $advert->price) {
                            $advert->price = $newPrice;
                            $mailer = new Mailing(
                                array(
                                    'price' => $newPrice,
                                    'id' => $advert->id,
                                    'url' => $advert->url,
                                    'adv' => $advert->advCode
                                )
                            );
                            $mailer->init();
                            $advert->updated_at = Carbon::now()->timestamp;
                            $advert->status = 'update';
                            $advert->save();
                        }
                    }
                }
            );
        } catch (\Exception $e) {
            throw new \Exception('Fail Parsing');
        }
    }
}
