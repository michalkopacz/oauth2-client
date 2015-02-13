<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 13.02.15
 * Time: 21:19
 */

namespace MostSignificantBit\OAuth2\Client;


use MostSignificantBit\OAuth2\Client\Response\AccessToken;
use MostSignificantBit\OAuth2\Client\Response\AccessTokenType;

class Client
{
    public function obtainAccessToken()
    {
        return new AccessToken('abcdef12345', AccessTokenType::BEARER());
    }
} 