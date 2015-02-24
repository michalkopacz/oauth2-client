<?php
namespace MostSignificantBit\OAuth2\Client\AccessToken;

interface RequestInterface
{
    /**
     * @return array
     */
    public function getBodyParameters();
} 