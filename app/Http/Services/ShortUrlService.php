<?php

namespace App\Http\Services;

use GuzzleHttp\Client;

class ShortUrlService
{
    public function __construct()
    {
        $this->client = new Client();
    }

    public function makeSortUrl($url)
    {
        $accessToken = '20f07f91f3303b2f66ab6f61698d977d69b83d64';
        $data = [
            'url' => $url,
        ];
        $response = $this->client->request(
            'POST',
            'https://api.pics.ee/v1/links/?access_token='.$accessToken,
            [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($data)
            ]
        );

        $contents = $response->getBody()->getContents();
        $contents = json_decode($contents);
        return $contents->data->picseeUrl;
    }
}
