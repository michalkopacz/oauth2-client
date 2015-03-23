<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Grant\RefreshToken;

use MostSignificantBit\OAuth2\Client\Assert\Assertion;
use MostSignificantBit\OAuth2\Client\AccessToken\RequestInterface as AccessTokenRequestInterface;
use MostSignificantBit\OAuth2\Client\Config\ClientType;
use MostSignificantBit\OAuth2\Client\Grant\AccessTokenRequestAwareGrantInterface;

class RefreshTokenGrant implements AccessTokenRequestAwareGrantInterface
{
    /**
     * @var AccessTokenRequest $accessTokenRequest
     */
    protected $accessTokenRequest;


    public function __construct(AccessTokenRequest $accessTokenRequest = null)
    {
        if ($accessTokenRequest !== null) {
            $this->setAccessTokenRequest($accessTokenRequest);
        }
    }

    /**
     * @param AccessTokenRequest $request
     */
    public function setAccessTokenRequest(AccessTokenRequestInterface $request)
    {
        Assertion::isInstanceOf($request, 'MostSignificantBit\OAuth2\Client\Grant\RefreshToken\AccessTokenRequest');

        $this->accessTokenRequest = $request;
    }

    /**
     * @return AccessTokenRequest
     */
    public function getAccessTokenRequest()
    {
        return $this->accessTokenRequest;
    }

    /**
     * @return ClientType[]
     */
    public function getSupportedClientTypesForAuthentication()
    {
        return array(ClientType::CONFIDENTIAL_TYPE());
    }
}
