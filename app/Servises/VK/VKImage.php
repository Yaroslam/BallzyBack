<?php

namespace App\Servises\VK;

use \GuzzleHttp\Client;
use Http\Client\Exception;
use VK\Client\VKApiClient;

class VKImage extends VKApiClient
{


    private $HttpClientForVK;

    function __construct(string $api_version = self::API_VERSION, ?string $language = null)
    {
        parent::__construct($api_version, $language);
        $this->HttpClientForVK = new Client();
    }


    public function loadImage($pathToFile){
        $serverUrl = $this->getServerUploadUrl();
        $response = $this->HttpClientForVK->request("POST", $serverUrl, ['verify' => false,
            'multipart' => [
                [
                    'name'     => 'file',
                    'contents' => file_get_contents($pathToFile),
                    'filename' => $pathToFile,
                ]]]);
        var_dump(json_decode($response->getBody(), true));
        return $this->savePhotoInServer($response->getBody());
    }


    private function savePhotoInServer($serverResponse){
        $serverResponseArray = json_decode($serverResponse, true);
        if(!array_key_exists("photo", $serverResponseArray)){
            var_dump($serverResponseArray['error']);
            return false;
        }
        $photo = stripslashes($serverResponseArray['photo']);
        return $this->photos()->saveMarketPhoto(env("VK_API_KEY"), ["group_id" =>  env("VK_PUBLICK_ID"),
                                                                        "photo" => $photo,
                                                                        "server" => $serverResponseArray['server'],
                                                                        "hash" => $serverResponseArray['hash']]);
    }


    private function getServerUploadUrl(){
        $serverData = $this->photos()->getMarketUploadServer(env("VK_API_KEY"), ["main_photo" => 1,
            "group_id" => env("VK_PUBLICK_ID"), ]);
        $serverUrl = $serverData['upload_url'];
        return $serverUrl;
    }



}
