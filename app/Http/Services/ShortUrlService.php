<?php

namespace App\Http\Services;

use Exception;
use GuzzleHttp\Client;

class ShortUrlService
{
    public function __construct()
    {
        $this->client = new Client();
    }

    public function makeSortUrl($url)
    {
        try {
            $accessToken = '20f07f91f3303b2f66ab6f61698d977d69b83d6';
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
            $url = $contents->data->picseeUrl;
        } catch (\Exception $e) {
            report($e);
            return $url;
        }
        return $contents->data->picseeUrl;
    }
}
