<?php

namespace App\Services\Action;

use App\Helpers\Helper;
use App\Models\Advert;
use App\Models\User;


/**
 * Class Record
 * @package App\Services\Action
 */
class Record
{
    private $request;

    /**
     * Record constructor.
     * @param $arr
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @throws \Exception
     */
    public function init()
    {
        try {
            $currentAdvert = new Advert();
            $currentUser = new User();

            $full_url = array_filter(explode('/', $this->request->url));
            $advCode = end($full_url);
            $currentAdvert = $currentAdvert->getByCodeOrCreateNew($advCode);
            if ($currentAdvert->url == null) {
                $currentAdvert->url = $this->request->url;
                $currentAdvert->advCode = $advCode;
                $currentAdvert->save();
            }
            $currentUser = $currentUser->getByEmailOrCreateNew($this->request->email);
            $test = $currentAdvert->users()->get();
            foreach ($test as $item) {
                $idsForAttach[] = $item->id;
            }

            $currentAdvert->users()->attach($currentUser->id);
        } catch (\Exception $e) {
            throw new \Exception('Fail Record');
        }
    }
}



