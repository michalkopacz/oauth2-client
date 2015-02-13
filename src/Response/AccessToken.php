<?php
namespace MostSignificantBit\OAuth2\Client\Response;


class AccessToken
{
    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @var AccessTokenType
     */
    protected $tokenType;

    /**
     * @var int
     */
    protected $expiresIn;

    /**
     * @var string
     */
    protected $refreshToken;

    /**
     * @var array
     */
    protected $scope;

    public function __construct($accessToken, AccessTokenType $tokenType)
    {
        $this->accessToken = $accessToken;
        $this->tokenType = $tokenType;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return AccessTokenType
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }

    /**
     * @param int $expiresIn
     */
    public function setExpiresIn($expiresIn)
    {
        $this->expiresIn = $expiresIn;
    }

    /**
     * @return int
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * @param string $refreshToken
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }

    /**
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @param array $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
    }

    /**
     * @return array
     */
    public function getScope()
    {
        return $this->scope;
    }
} 