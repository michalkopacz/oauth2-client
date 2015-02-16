<?php
namespace MostSignificantBit\OAuth2\Client\Grant\RefreshToken\AccessToken;

use MostSignificantBit\OAuth2\Client\Grant\AbstractAccessTokenRequest;
use MostSignificantBit\OAuth2\Client\Parameter\GrantType;

class Request extends AbstractAccessTokenRequest
{
    /**
     * OAuth2: REQUIRED
     *
     * @var string
     */
    protected $refreshToken;

    protected $scope;

    public function __construct($refreshToken)
    {

    }

    /**
     * @return GrantType
     */
    public function getGrantType()
    {
        return GrantType::REFRESH_TOKEN();
    }
} 