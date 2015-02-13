<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 13.02.15
 * Time: 23:35
 */

namespace MostSignificantBit\OAuth2\Client\Http;

use GuzzleHttp\Client as GuzzleHttp;

class Guzzle5Adapter implements ClientInterface
{
    /**
     * @var GuzzleHttp
     */
    protected $client;

    public function __construct(GuzzleHttp $client)
    {
        $this->client = $client;
    }

    public function post($url, $params)
    {
        $response = $this->client->post($url, array('body' => $params));

        return $response->json();
    }
}