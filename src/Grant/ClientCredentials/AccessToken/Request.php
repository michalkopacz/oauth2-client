<?php
namespace MostSignificantBit\OAuth2\Client\Grant\ClientCredentials\AccessToken;

use MostSignificantBit\OAuth2\Client\Grant\AbstractAccessTokenRequest;
use MostSignificantBit\OAuth2\Client\Parameter\GrantType;

class Request extends AbstractAccessTokenRequest
{
    protected $scope;

    /**
     * @return GrantType
     */
    public function getGrantType()
    {
        return GrantType::CLIENT_CREDENTIALS();
    }
} 