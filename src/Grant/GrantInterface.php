<?php

namespace MostSignificantBit\OAuth2\Client\Grant;

use MostSignificantBit\OAuth2\Client\Config\ClientType;

interface GrantInterface
{
    /**
     * @return ClientType[]
     */
    public function getSupportedClientTypesForAuthentication();
} 