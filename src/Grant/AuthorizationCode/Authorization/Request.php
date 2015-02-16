<?php
namespace MostSignificantBit\OAuth2\Client\Grant\AuthorizationCode\Authorization;

use MostSignificantBit\OAuth2\Client\Grant\AbstractAuthorizationRequest;
use MostSignificantBit\OAuth2\Client\Parameter\ResponseType;

class Request extends AbstractAuthorizationRequest
{
    /**
     * @return ResponseType
     */
    public function getResponseType()
    {
        return ResponseType::CODE();
    }
}