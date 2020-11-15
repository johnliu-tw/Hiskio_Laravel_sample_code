<?php

namespace App\Http\Services;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ShortUrlService
{
    public function __construct()
    {
        $this->client = new Client();
    }

    public function makeSortUrl($url)
    {
        try {
            $accessToken = '20f07f91f3303b2f66ab6f61698d977d69b83d64';
            $data = [
                'url' => $url,
            ];
            $postData = [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($data)
            ];
            Log::info('postData', ['data' => $postData]);
            $response = $this->client->request(
                'POST',
                'https://api.pics.ee/v1/links/?access_token='.$accessToken,
                $postData
            );
            $contents = $response->getBody()->getContents();
            Log::info('responseData', ['data' => $contents]);
            $contents = json_decode($contents);
            $url = $contents->data->picseeUrl;
        } catch (\Exception $e) {
            report($e);
            return $url;
        }
        return $url;
    }
}
