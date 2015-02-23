<?php
namespace MostSignificantBit\OAuth2\Client\Grant\ResourceOwnerPasswordCredentials;

use MostSignificantBit\OAuth2\Client\Assert\Assertion;
use MostSignificantBit\OAuth2\Client\Grant\AccessTokenRequestAwareGrantInterface;
use MostSignificantBit\OAuth2\Client\Grant\AccessToken\RequestInterface as AccessTokenRequestInterface;

class ResourceOwnerPasswordCredentialsGrant implements AccessTokenRequestAwareGrantInterface
{
    /**
     * @var AccessTokenRequest $request
     */
    protected $accessTokenRequest;

    public function __construct(AccessTokenRequest $request)
    {
        $this->setAccessTokenRequest($request);
    }

    /**
     * @param AccessTokenRequest $request
     */
    public function setAccessTokenRequest(AccessTokenRequestInterface $request)
    {
        Assertion::isInstanceOf($request, '\MostSignificantBit\OAuth2\Client\Grant\ResourceOwnerPasswordCredentials\AccessTokenRequest');

        $this->accessTokenRequest = $request;
    }

    /**
     * @return AccessTokenRequest
     */
    public function getAccessTokenRequest()
    {
        return $this->accessTokenRequest;
    }
}