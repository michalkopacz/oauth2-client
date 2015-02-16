<?php
namespace MostSignificantBit\OAuth2\Client\Grant;

use MostSignificantBit\OAuth2\Client\Parameter\GrantType;

abstract class AbstractAccessTokenRequest implements AccessTokenRequestInterface
{
    /**
     * @return GrantType
     */
    abstract public function getGrantType();

    public function getBodyParameters()
    {

    }
} 