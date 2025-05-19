<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ImportNewsService
{

    /**
     * @throws GuzzleException
     */
    public function handle(string $url): array
    {
        $client = new Client(['verify' => false]);
        $response = $client->get($url);

        $data = collect(json_decode($response->getBody(), true));
        return $data->get('articles');
    }
}
