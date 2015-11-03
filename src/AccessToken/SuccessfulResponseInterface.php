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

interface SuccessfulResponseInterface
{
    /**
     * @param AccessToken $accessToken
     */
    public function setAccessToken(AccessToken $accessToken);

    /**
     * @return AccessToken
     */
    public function getAccessToken();

    /**
     * @param TokenType $tokenType
     */
    public function setTokenType(TokenType $tokenType);

    /**
     * @return TokenType
     */
    public function getTokenType();

    /**
     * @param ExpiresIn $expiresIn
     */
    public function setExpiresIn(ExpiresIn $expiresIn);

    /**
     * @return ExpiresIn
     */
    public function getExpiresIn();

    /**
     * @param RefreshToken $refreshToken
     */
    public function setRefreshToken(RefreshToken $refreshToken);

    /**
     * @return RefreshToken
     */
    public function getRefreshToken();

    /**
     * @param Scope $scope
     */
    public function setScope(Scope $scope);

    /**
     * @return Scope
     */
    public function getScope();
}
