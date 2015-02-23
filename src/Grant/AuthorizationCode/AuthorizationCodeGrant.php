<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 15.02.15
 * Time: 12:46
 */
namespace MostSignificantBit\OAuth2\Client\Grant\AuthorizationCode;

use MostSignificantBit\OAuth2\Client\Assert\Assertion;
use MostSignificantBit\OAuth2\Client\Grant\AccessToken\RequestInterface as AccessTokenRequestInterface;
use MostSignificantBit\OAuth2\Client\Grant\AccessTokenRequestAwareGrantInterface;

class AuthorizationCodeGrant implements AccessTokenRequestAwareGrantInterface
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
     * @param AccessTokenRequestInterface $request
     */
    public function setAccessTokenRequest(AccessTokenRequestInterface $request)
    {
        Assertion::isInstanceOf($request, '\MostSignificantBit\OAuth2\Client\Grant\AuthorizationCode\AccessTokenRequest');

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