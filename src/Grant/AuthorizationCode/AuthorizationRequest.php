<?php
namespace MostSignificantBit\OAuth2\Client\Grant\AuthorizationCode;

use MostSignificantBit\OAuth2\Client\Authorization\AbstractAuthorizationRequest;
use MostSignificantBit\OAuth2\Client\Parameter\ResponseType;

class AuthorizationRequest extends AbstractAuthorizationRequest
{
    /**
     * @return ResponseType
     */
    public function getResponseType()
    {
        return ResponseType::CODE();
    }
}