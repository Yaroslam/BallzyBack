<?php

namespace App\Servises\Parsers;

use DOMDocument;
use DOMXPath;
use http\Params;
use PHPHtmlParser\Exceptions\EmptyCollectionException;
use App\Servises\Parsers\Parser;
use stringEncode\Exception;

class ManShoesParserClass extends Parser
{
    function getShoesTable()
    {
        return $this->dom->find(".page-main")->find(".columns")->find(".column")->find("ol")->find("li");
    }

    public function getBrands(): array
    {
        $res = [];
        $forms = $this->dom->find('form');
        foreach ($forms as $form) {
            if ($form->getAttribute("data-amshopby-filter-request-var") == "brands") {
                $brands = $form->find('li');
                foreach ($brands as $brand) {
                    $res[$brand->getAttribute('data-label')] = $brand->find('input')->getAttribute("value");
                }
            }
        }
        return $res;
    }

    public function countBrands(): array
    {
        $brandsName = array_keys(self::getBrands());
        $i = 0;
        $forms = $this->dom->find('form');
        $countBrands = [];
        foreach ($forms as $form) {
            if ($form->getAttribute("data-amshopby-filter-request-var") == "brands") {
                $brands = $form->find('li');
                foreach ($brands as $brand) {
                    $countBrands[$brandsName[$i]] = $brand->find('a')->find('.count')->text;
                    $i++;
                }
            }
        }
        return $countBrands;
    }


    public function getShoesLink($shoes): string
    {
        return $shoes->find("a")->getAttribute("href");
    }

    public function getShoesName(): string
    {
        $div = $this->dom->find(".product-info-main")->find(".product-info-price")
            ->find(".product")->find('div');
        return $div->text;
    }

    public function getShoesImage(): string
    {
        $res = "";
        $div = $this->dom->find("img");
        foreach ($div as $d) {
            if ($d->getAttribute('class') == "gallery-placeholder__image") {
                $res = $d->getAttribute('src');
            }
        }
        return $res;
    }

    public function getShoesPrice(): string
    {
        if (count($this->dom->find(".product-info-main")->find(".product-info-price")
                ->find(".price-box")->find('.old-price')) > 0) {
            $div = $this->dom->find(".product-info-main")->find(".product-info-price")
                ->find(".price-box")->find('.old-price')->find('.price-wrapper');
        } else {
            $div = $this->dom->find(".product-info-main")->find(".product-info-price")
                ->find(".price-box")->find('.normal-price')->find('.price-wrapper');
        }
        return $div->getAttribute("data-price-amount");
    }

    public function getSizes($html): array
    {
        $dom_document = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom_document->loadHTML($html);
        libxml_use_internal_errors(false);
        $res = [];

        $sctipts = $dom_document->getElementsByTagName("script");
        foreach ($sctipts as $sctipt) {
            if(preg_match("[data-role=swatch-options]", $sctipt->textContent)) {
                $sctipt = json_decode($sctipt->textContent, true);
                $res = $sctipt;
            }
        }
        return $res;
    }
}
