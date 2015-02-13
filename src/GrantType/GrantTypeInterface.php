<?php

namespace MostSignificantBit\OAuth2\Client\GrantType;

interface GrantTypeInterface
{
    public function getGrantType();

    /**
     * @return array
     */
    public function getParams();
} 