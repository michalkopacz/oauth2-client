<?php
namespace MostSignificantBit\OAuth2\Client\AccessToken;

use MostSignificantBit\OAuth2\Client\Parameter\GrantType;
use MostSignificantBit\OAuth2\Client\AccessToken\RequestInterface as AccessTokenRequestInterface;

abstract class AbstractRequest implements AccessTokenRequestInterface
{
    /**
     * @return GrantType
     */
    abstract public function getGrantType();
} 