<?php
namespace App\Servises\Parsers;
require_once __DIR__.'/../../../vendor/autoload.php';

use PHPHtmlParser\Dom;
use App\Servises\Parsers\ManShoesParserClass;
use src\Request\RequestClient;
use src\Database\DB;
use Dotenv;

function parse(): void
{
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '../../../../');
    $dotenv->load();
    $db = new DB($_ENV['DB_HOST'] . ":" . $_ENV['DB_PORT'], $_ENV['DB_DATABASE'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);


    $requester = new RequestClient();
    $requester->setURL("https://ballzy.eu/lt/shoes");
//
    $parser = new ManShoesParserClass();
    $shoesCardParser = new ManShoesParserClass();
//
    $requester->makeGetRequest();
    $body = (string)$requester->getResponse()->getBody();
    $parser->setDocument($body);


    $brands = $parser->getBrands();
    $brandsCount = $parser->countBrands();
    foreach (array_keys($brands) as $brand) {
        $brandId = $brands[$brand];
        if (!$db->Select("Brands", [], ['brand_name'], ['brand_name'], [$brand], ['='])) {
            $db->EnterToTable(['brand_name'], [$brand], "Brands");
        }

        $page = 1;
        $requester->setURL("https://ballzy.eu/lt/shoes.html?brands=$brandId&p=$page");
        $requester->makeGetRequest();
        $body = (string)$requester->getResponse()->getBody();
        $parser->setDocument($body);

        while ($brandsCount[$brand] > 0) {
            $requester->setURL("https://ballzy.eu/lt/shoes.html?brands=$brandId&p=$page");
            $page++;
            $requester->makeGetRequest();
            $body = (string)$requester->getResponse()->getBody();
            $parser->setDocument($body);

            $products = $parser->getShoesTable();
            foreach ($products as $product) {
                $productData = $product->find("div");
                foreach ($productData as $data) {
                    if ($data->getAttribute("class") == "product-item__top-box") {
                        $linkToShoes = $parser->getShoesLink($data);
                        $requester->setURL($linkToShoes);
                        $requester->makeGetRequest();
                        $body = (string)$requester->getResponse()->getBody();
                        $shoesCardParser->setDocument($body);


                        $shoesImg = $shoesCardParser->getShoesImage();
                        $shoesName = $shoesCardParser->getShoesName();
                        $shoesPrice = $shoesCardParser->getShoesPrice();
                        $brandTableId = $db->Select("Brands", [], "*", ["brand_name"], [$brand], ["="])['brand_id'];
                        $sizes = $shoesCardParser->getSizes($body)["[data-role=swatch-options]"]["Magento_Swatches/js/swatch-renderer"]["jsonConfig"]["attributes"]['139']["options"];
                        $sizesId = [];
                        foreach ($sizes as $size) {
                            $sizeVal = $size['label'];
                            if (!$db->Select("Sizes", [], ['size'], ['size'], [$sizeVal], ['='])) {
                                $db->EnterToTable(["size"], [$sizeVal], "Sizes");
                            }

                            if ($size['available'] == 1) {
                                $sizesId[] = $db->Select("Sizes", [], ['size_id'], ['size'], [$sizeVal], ['='])['size_id'];
                            }
                        }

                        if (!$db->Select("Shoes", [], ['link'], ['link'], [$linkToShoes], ['='])) {
                            $db->EnterToTable(["shoes_name", "brand_id", "link", "img", "price_euro", "price_roubles"],
                                [$shoesName, $brandTableId, $linkToShoes, $shoesImg, $shoesPrice, $shoesPrice * 62.78 + 9000], "Shoes");
                        }

                        $shoeId = $db->Select("Shoes", [], ['shoe_id'], ['link'], [$linkToShoes], ['='])['shoe_id'];
                        foreach ($sizesId as $id) {
                            if (!$db->Select("Shoes_sizes", ["AND"], ['size_shoes_id'], ["shoe_id", 'size_id'], [$shoeId, $id], ['=', "="])) {
                                $db->EnterToTable(["shoe_id", 'size_id'], [$shoeId, $id], "Shoes_sizes");
                            }
                        }


                    }
                }
            }
            $brandsCount[$brand] -= 24;
        }
    }
}
