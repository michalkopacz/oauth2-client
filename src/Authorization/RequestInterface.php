<?php
namespace MostSignificantBit\OAuth2\Client\Authorization;

interface RequestInterface
{
    public function setClientId($clientId);

    public function getQueryParams();
} 