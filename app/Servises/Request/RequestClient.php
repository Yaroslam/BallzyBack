<?php

namespace src\Request;
use \GuzzleHttp\Client;


class RequestClient
{
    protected $URL;
    protected $response;
    protected $client;
    protected $postParameters;
    protected $getParameters;

    function __construct()
    {
        $this->client = new Client();
    }

    public function setURL($url): void
    {
        $this->URL = $url;
    }

    public function setPostParameters($postParameters): void
    {
        $this->postParameters = $postParameters;
    }

    public function setGetParameters($params): void
    {
        $this->getParameters = $params;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getURL(): string
    {
        return $this->URL;
    }

    public function changeURL($newURL): void
    {
        $this->URL = $newURL;
    }

    public function makePostRequest($type): void
    {
        $this->response = $this->client->request('POST', $this->URL, ['verify' => false,$type => $this->postParameters]);
    }

    public function makeGetRequest(): void
    {
        $this->response = $this->client->request('GET', $this->URL, ['verify' => false,'query' => $this->getParameters]);

    }

    public function changePostParameters($parameter, $newVal): void
    {
        $this->postParameters[$parameter] = $newVal;
    }

    public function addPostParameter($parameter, $val): void
    {
        $this->postParameters[$parameter] = $val;
    }



}
