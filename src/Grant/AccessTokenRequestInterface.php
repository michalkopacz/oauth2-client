<?php
namespace MostSignificantBit\OAuth2\Client\Grant;

interface AccessTokenRequestInterface
{
    /**
     * @return array
     */
    public function getBodyParameters();
} 