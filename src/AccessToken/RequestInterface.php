<?php
namespace MostSignificantBit\OAuth2\Client\AccessToken;

use MostSignificantBit\OAuth2\Client\Parameter\GrantType;

interface RequestInterface
{
    /**
     * @return array
     */
    public function getBodyParameters();

    /**
     * @return GrantType
     */
    public function getGrantType();
}
