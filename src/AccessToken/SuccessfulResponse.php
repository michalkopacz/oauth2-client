<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

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

    /**
     * @param AccessToken $accessToken
     * @param TokenType $tokenType
     */
    public function __construct(AccessToken $accessToken, TokenType $tokenType)
    {
        $this->accessToken = $accessToken;
        $this->tokenType = $tokenType;
    }

    /**
     * @param AccessToken $accessToken
     */
    public function setAccessToken(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return AccessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param ExpiresIn $expiresIn
     */
    public function setExpiresIn(ExpiresIn $expiresIn)
    {
        $this->expiresIn = $expiresIn;
    }

    /**
     * @return ExpiresIn
     */
    public function getExpiresIn()
    {
        return $this->expiresIn;
    }

    /**
     * @param RefreshToken $refreshToken
     */
    public function setRefreshToken(RefreshToken $refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }

    /**
     * @return RefreshToken
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @param Scope $scope
     */
    public function setScope(Scope $scope)
    {
        $this->scope = $scope;
    }

    /**
     * @return Scope
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @param TokenType $tokenType
     */
    public function setTokenType(TokenType $tokenType)
    {
        $this->tokenType = $tokenType;
    }

    /**
     * @return TokenType
     */
    public function getTokenType()
    {
        return $this->tokenType;
    }
}
