<?php
namespace MostSignificantBit\OAuth2\Client\Grant\AccessToken;

interface RequestInterface
{
    /**
     * @return array
     */
    public function getBodyParameters();
} 