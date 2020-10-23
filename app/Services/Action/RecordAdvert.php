<?php
namespace App\Services\Action;

use App\Models\Advert;

class RecordAdvert
{
    private $advCode;

    public function __construct(string $advCode){
        $this->advCode = $advCode;
    }

    public function init(){
       return $this->checkAdv();
    }

    private function checkAdv(){
        return (Advert::where('advCode', '=', $this->advCode)->first() === null) ?  $this->addAdv() : Advert::where('advCode', '=', $this->advCode)->first();
    }

    private function addAdv(){
        $advert = new Advert;
        $advert->advCode = $this->advCode;
        return $advert;
    }

}
