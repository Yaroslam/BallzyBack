<?php
namespace App\Servises\Parsers;

use PHPHtmlParser\Dom;
require_once __DIR__.'/../../../vendor/autoload.php';


class Parser
{

    protected Dom $dom;

    function __construct()
    {
        $this->dom = new Dom();
    }

    public function setDocument($document): void
    {
        $this->dom->loadStr($document);
    }


    public function setByUrl($url): void
    {
        $this->dom->loadFromUrl($url);
    }
}
