<?php

namespace App\Servises\VK;

use App\Models\Shoe;
use VK\Client\VKApiClient;

class VKMarket extends VKApiClient
{

    function __construct(string $api_version = self::API_VERSION, ?string $language = null)
    {
        parent::__construct($api_version, $language);
    }


    public function addToMarket($photoData, $name, $desc, $category, $price){
        sleep(3);
        return $this->market()->add(env("VK_API_KEY"), ['owner_id' => "-".env("VK_PUBLICK_ID"), 'name' => $name, 'description' => $desc, 'category_id' => $category,
                                                      'price' => $price, 'main_photo_id' => $photoData[0]['id']]);
    }

    public function getMarketProducts(){
        return $this->market()->get(env("VK_API_KEY"), ['owner_id' => "-".env("VK_PUBLICK_ID")]);
    }

    public function cleanMarket(){
        $products = $this->getMarketProducts();
        while ($products['count'] > 0) {
            foreach ($products['items'] as $product) {
                Shoe::where("market_id", $product["id"])->update(["inMarket" => 0, "market_id" => null]);
                $this->market()->delete(env("VK_API_KEY"), ["owner_id" => "-" . env("VK_PUBLICK_ID"), "item_id" => $product['id']]);
                sleep(3);
            }
            $products = $this->getMarketProducts();
        }
    }

    public function getPublicAlbums(){
        return $this->market()->getAlbums(env("VK_API_KEY"), ["owner_id" => "-".env('VK_PUBLICK_ID')]);
    }

    public function createAlbum($title){
        return $this->market()->addAlbum(env("VK_API_KEY"), ["owner_id" => "-".env("VK_PUBLICK_ID"),
                                                                "title" => $title]);
    }

    public function addToMarketInAlbum($albumId, $itemId){
        $this->market()->addToAlbum(env("VK_API_KEY"), ["owner_id" => "-".env("VK_PUBLICK_ID"), "item_id" => $itemId,
                                                            "album_ids" => $albumId]);
    }







}
