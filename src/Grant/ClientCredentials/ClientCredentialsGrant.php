<?php
namespace MostSignificantBit\OAuth2\Client\Grant\ClientCredentials;

use MostSignificantBit\OAuth2\Client\Assert\Assertion;
use MostSignificantBit\OAuth2\Client\AccessToken\RequestInterface as AccessTokenRequestInterface;
use MostSignificantBit\OAuth2\Client\Config\ClientType;
use MostSignificantBit\OAuth2\Client\Grant\AccessTokenRequestAwareGrantInterface;

class ClientCredentialsGrant implements AccessTokenRequestAwareGrantInterface
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
        Assertion::isInstanceOf($request, 'MostSignificantBit\OAuth2\Client\Grant\ClientCredentials\\AccessTokenRequest');

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
