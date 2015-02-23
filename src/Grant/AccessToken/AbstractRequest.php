<?php
namespace MostSignificantBit\OAuth2\Client\Grant\AccessToken;

use MostSignificantBit\OAuth2\Client\Parameter\GrantType;
use MostSignificantBit\OAuth2\Client\Grant\AccessToken\RequestInterface as AccessTokenRequestInterface;

abstract class AbstractRequest implements AccessTokenRequestInterface
{
    /**
     * @return GrantType
     */
    abstract public function getGrantType();
} 