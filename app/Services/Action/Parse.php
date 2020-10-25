<?php

namespace App\Services\Action;

use App\Models\Advert;
use voku\helper\HtmlDomParser;

/**
 * Class Parse
 * @package App\Services\Action
 */
class Parse
{
    private $url;
    private $class = "";

    /**
     * Parse constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * set final class for parse in HtmlDom
     *
     * @param $class
     */
    public function setParseClass($class)
    {
        $this->class = $class;
    }

    /**
     * @return string
     */
    public function getParseClass()
    {
        return $this->class;
    }


    /**
     * Parse HtmlDom by url from construct method
     *
     * @return float|null
     */
    public function parseElement()
    {
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
