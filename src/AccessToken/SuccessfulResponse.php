<?php
namespace MostSignificantBit\OAuth2\Client\AccessToken;

use MostSignificantBit\OAuth2\Client\Parameter\AccessToken;
use MostSignificantBit\OAuth2\Client\Parameter\ExpiresIn;
use MostSignificantBit\OAuth2\Client\Parameter\RefreshToken;
use MostSignificantBit\OAuth2\Client\Parameter\Scope;
use MostSignificantBit\OAuth2\Client\Parameter\TokenType;

class SuccessfulResponse implements SuccessfulResponseInterface
{
    /**
     * @var AccessToken
     */
    protected $accessToken;

    /**
     * @var TokenType
     */
    protected $tokenType;

    /**
     * @var ExpiresIn
     */
    protected $expiresIn;

    /**
     * @var RefreshToken
     */
    protected $refreshToken;

    /**
     * @var Scope
     */
    protected $scope;

    public function __construct($accessToken, TokenType $tokenType)
    {
        $this->accessToken = $accessToken;
        $this->tokenType = $tokenType;
    }

    /**
     * @param \MostSignificantBit\OAuth2\Client\Parameter\AccessToken $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return \MostSignificantBit\OAuth2\Client\Parameter\AccessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param \MostSignificantBit\OAuth2\Client\Parameter\ExpiresIn $expiresIn
     */
    public function setExpiresIn($expiresIn)
    {
        $this->expiresIn = $expiresIn;
    }

    /**
     * @return \MostSignificantBit\OAuth2\Client\Parameter\ExpiresIn
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * @param \MostSignificantBit\OAuth2\Client\Parameter\RefreshToken $refreshToken
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }

    /**
     * @return \MostSignificantBit\OAuth2\Client\Parameter\RefreshToken
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @param \MostSignificantBit\OAuth2\Client\Parameter\Scope $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
    }

    /**
     * @return \MostSignificantBit\OAuth2\Client\Parameter\Scope
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @param \MostSignificantBit\OAuth2\Client\Parameter\TokenType $tokenType
     */
    public function setTokenType($tokenType)
    {
        $this->tokenType = $tokenType;
    }

    /**
     * @return \MostSignificantBit\OAuth2\Client\Parameter\TokenType
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }
}
