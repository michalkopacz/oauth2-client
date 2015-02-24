<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 15.02.15
 * Time: 12:46
 */
namespace MostSignificantBit\OAuth2\Client\Grant\AuthorizationCode;

use MostSignificantBit\OAuth2\Client\Assert\Assertion;
use MostSignificantBit\OAuth2\Client\AccessToken\RequestInterface as AccessTokenRequestInterface;
use MostSignificantBit\OAuth2\Client\Grant\AccessTokenRequestAwareGrantInterface;
use MostSignificantBit\OAuth2\Client\Grant\AuthorizationRequestAwareGrantInterface;
use MostSignificantBit\OAuth2\Client\Authorization\AuthorizationRequestInterface;

class AuthorizationCodeGrant implements AccessTokenRequestAwareGrantInterface, AuthorizationRequestAwareGrantInterface
{
    /**
     * @var AccessTokenRequest $accessTokenRequest
     */
    protected $accessTokenRequest;

    /**
     * @var AuthorizationRequest $authorizationRequest
     */
    protected $authorizationRequest;

    public function __construct(AccessTokenRequest $accessTokenRequest = null, AuthorizationRequest $authorizationRequest = null)
    {
        if ($accessTokenRequest !== null) {
            $this->setAccessTokenRequest($accessTokenRequest);
        }

        if ($authorizationRequest !== null) {
            $this->setAuthorizationRequest($authorizationRequest);
        }
    }

    /**
     * @param AuthorizationRequest $request
     */
    public function setAccessTokenRequest(AccessTokenRequestInterface $request)
    {
        Assertion::isInstanceOf($request, '\MostSignificantBit\OAuth2\Client\AuthorizationCode\AccessTokenRequest');

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
     * @param AuthorizationRequest $request
     */
    public function setAuthorizationRequest(AuthorizationRequestInterface $request)
    {
        $this->authorizationRequest = $request;
    }

    /**
     * @return AuthorizationRequest
     */
    public function getAuthorizationRequest()
    {
        return $this->authorizationRequest;
    }

    /**
     * @return ClientType[]
     */
    public function getSupportedClientTypesForAuthentication()
    {
        return array(ClientType::CONFIDENTIAL_TYPE());
    }
}
