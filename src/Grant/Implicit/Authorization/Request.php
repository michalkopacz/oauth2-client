<?php
namespace MostSignificantBit\OAuth2\Client\Grant\Implicit\Authorization;

use MostSignificantBit\OAuth2\Client\Grant\AbstractAuthorizationRequest;
use MostSignificantBit\OAuth2\Client\Parameter\ResponseType;

class Request extends AbstractAuthorizationRequest
{
    /**
     * @return ResponseType
     */
    public function getResponseType()
    {
        return ResponseType::TOKEN();
    }
} 