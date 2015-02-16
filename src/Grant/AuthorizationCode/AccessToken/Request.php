<?php
namespace MostSignificantBit\OAuth2\Client\Grant\AuthorizationCode\AccessToken;

use MostSignificantBit\OAuth2\Client\Grant\AbstractAccessTokenRequest;
use MostSignificantBit\OAuth2\Client\Parameter\GrantType;

class Request extends AbstractAccessTokenRequest
{
    /**
     * OAuth2: REQUIRED
     *
     * @var string
     */
    protected $code;

    protected $redirectUri;

    protected $clientId;

    public function __construct($code)
    {

    }

    /**
     * @return GrantType
     */
     public function getGrantType()
     {
         return GrantType::AUTHORIZATION_CODE();
     }
} 