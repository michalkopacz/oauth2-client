<?php
namespace MostSignificantBit\OAuth2\Client\Http;


interface ClientInterface
{
    public function post($url, $params);
} 