<?php
namespace MostSignificantBit\OAuth2\Client\Grant;

interface AuthorizationRequestInterface
{

    /**
     * ClientId is required, but we set it in \MostSignificantBit\OAuth2\Client\Client from config;
     *
     * @param string $clientId
     */
    public function setClientId($clientId);


    /**
     * @return array
     */
    public function getQueryParameters();
} 