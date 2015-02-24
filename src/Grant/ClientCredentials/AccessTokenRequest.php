<?php
namespace MostSignificantBit\OAuth2\Client\Grant\ClientCredentials;

use MostSignificantBit\OAuth2\Client\AccessToken\AbstractRequest as AbstractAccessTokenRequest;
use MostSignificantBit\OAuth2\Client\Parameter\GrantType;
use MostSignificantBit\OAuth2\Client\Parameter\Scope;

class AccessTokenRequest extends AbstractAccessTokenRequest
{
    /**
     * OAuth2: OPTIONAL
     *
     * @var Scope
     */
    protected $scope;

    /**
     * @return GrantType
     */
    public function getGrantType()
    {
        return GrantType::CLIENT_CREDENTIALS();
    }

    /**
     * @param \MostSignificantBit\OAuth2\Client\Parameter\Scope $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
    }

    /**
     * @return \MostSignificantBit\OAuth2\Client\Parameter\Scope
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @return array
     */
    public function getBodyParameters()
    {
        $parameters = array(
            'grant_type' => $this->getGrantType()->getValue(),
        );

        if (isset($this->scope)) {
            $parameters['scope'] = $this->getScope()->getScopeParameter();
        }

        return $parameters;
    }
}
