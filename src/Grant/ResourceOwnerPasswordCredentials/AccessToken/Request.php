<?php
namespace MostSignificantBit\OAuth2\Client\Grant\ResourceOwnerPasswordCredentials\AccessToken;

use MostSignificantBit\OAuth2\Client\Grant\AbstractAccessTokenRequest;
use MostSignificantBit\OAuth2\Client\Parameter\GrantType;

class Request extends AbstractAccessTokenRequest
{
    /**
     * OAuth2: REQUIRED
     *
     * @var string
     */
    protected $username;

    /**
     * OAuth2: REQUIRED
     *
     * @var string
     */
    protected $password;

    protected $scope;

    public function __construct($username, $password){

    }

    /**
     * @return GrantType
     */
    public function getGrantType()
    {
        return GrantType::PASSWORD();
    }
} 