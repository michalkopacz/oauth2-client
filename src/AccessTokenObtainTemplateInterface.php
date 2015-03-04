<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client;

use Ivory\HttpAdapter\Message\ResponseInterface;
use Ivory\HttpAdapter\Message\RequestInterface;
use MostSignificantBit\OAuth2\Client\AccessToken\SuccessfulResponseInterface as AccessTokenSuccessfulResponseInterface;
use MostSignificantBit\OAuth2\Client\AccessToken\RequestInterface as AccessTokenRequestInterface;
use MostSignificantBit\OAuth2\Client\Exception\TokenException;

/**
 * Describe algorithm template to obtain access token
 */
interface AccessTokenObtainTemplateInterface
{
    /**
     * @param AccessTokenRequestInterface $accessTokenRequest
     * @return RequestInterface
     */
    public function convertAccessTokenRequestToHttpRequest(AccessTokenRequestInterface $accessTokenRequest);

    /**
     * @param RequestInterface $httpRequest
     * @return ResponseInterface
     */
    public function sendHttpRequest(RequestInterface $httpRequest);

    /**
     * @param ResponseInterface $httpResponse
     * @return bool
     */
    public function isSuccessfulResponse(ResponseInterface $httpResponse);

    /**
     * @param ResponseInterface $httpResponse
     * @return AccessTokenSuccessfulResponseInterface
     */
    public function convertHttpResponseToAccessTokenSuccessfulResponse(ResponseInterface $httpResponse);

    /**
     * @param ResponseInterface $httpResponse
     * @throws TokenException
     */
    public function throwTokenException(ResponseInterface $httpResponse);
}
