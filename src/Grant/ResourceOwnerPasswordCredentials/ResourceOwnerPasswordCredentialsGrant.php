<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Grant\ResourceOwnerPasswordCredentials;

use MostSignificantBit\OAuth2\Client\Assert\Assertion;
use MostSignificantBit\OAuth2\Client\Config\ClientType;
use MostSignificantBit\OAuth2\Client\Grant\AccessTokenRequestAwareGrantInterface;
use MostSignificantBit\OAuth2\Client\AccessToken\RequestInterface as AccessTokenRequestInterface;

class ResourceOwnerPasswordCredentialsGrant implements AccessTokenRequestAwareGrantInterface
{
    /**
     * @var AccessTokenRequest $request
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
        Assertion::isInstanceOf($request, 'MostSignificantBit\OAuth2\Client\Grant\ResourceOwnerPasswordCredentials\AccessTokenRequest');

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
        return array(ClientType::PUBLIC_TYPE(), ClientType::CONFIDENTIAL_TYPE());
    }
}
