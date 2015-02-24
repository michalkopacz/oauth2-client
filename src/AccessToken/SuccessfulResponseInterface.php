<?php
namespace MostSignificantBit\OAuth2\Client\AccessToken;

interface SuccessfulResponseInterface
{
    /**
     * @param \MostSignificantBit\OAuth2\Client\Parameter\AccessToken $accessToken
     */
    public function setAccessToken($accessToken);

    /**
     * @return \MostSignificantBit\OAuth2\Client\Parameter\AccessToken
     */
    public function getAccessToken();

    /**
     * @param \MostSignificantBit\OAuth2\Client\Parameter\TokenType $tokenType
     */
    public function setTokenType($tokenType);

    /**
     * @return \MostSignificantBit\OAuth2\Client\Parameter\TokenType
     */
    public function getTokenType();

    /**
     * @param \MostSignificantBit\OAuth2\Client\Parameter\ExpiresIn $expiresIn
     */
    public function setExpiresIn($expiresIn);

    /**
     * @return \MostSignificantBit\OAuth2\Client\Parameter\ExpiresIn
     */
    public function getExpiresIn();

    /**
     * @param \MostSignificantBit\OAuth2\Client\Parameter\RefreshToken $refreshToken
     */
    public function setRefreshToken($refreshToken);

    /**
     * @return \MostSignificantBit\OAuth2\Client\Parameter\RefreshToken
     */
    public function getRefreshToken();

    /**
     * @param \MostSignificantBit\OAuth2\Client\Parameter\Scope $scope
     */
    public function setScope($scope);

    /**
     * @return \MostSignificantBit\OAuth2\Client\Parameter\Scope
     */
    public function getScope();
} 