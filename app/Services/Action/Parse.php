<?php
namespace App\Services\Action;

use App\Models\Advert;
use voku\helper\HtmlDomParser;
class Parse
{
    private $url;
    private $class = "";

    public function __construct(string $url){
        $this->url = $url;
    }

    public function setParseClass($class){
        $this->class = $class;
    }

    public function getParseClass(){
        return $this->class;
    }

    public function init(){
       return $this->parsePrice();
    }

    private function parsePrice(){
        try {
            $dom = HtmlDomParser::file_get_html($this->url);
            $elements = $dom->findMulti($this->class)->text();
            $price = (float)preg_replace("/\s+/", "", $elements[0]);
            return $price;
        } catch (\Throwable $th) {
            return null;
        }
    }
}
