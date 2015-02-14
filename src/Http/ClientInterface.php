<?php
namespace MostSignificantBit\OAuth2\Client\Http;


interface ClientInterface
{
    public function postAccessToken($url, $bodyParams, $clientCredentials);
} 