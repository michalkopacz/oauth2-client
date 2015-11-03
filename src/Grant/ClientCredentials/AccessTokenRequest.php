<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Grant\ClientCredentials;

use MostSignificantBit\OAuth2\Client\AccessToken\RequestInterface as AccessTokenRequestInterface;
use MostSignificantBit\OAuth2\Client\Parameter\GrantType;
use MostSignificantBit\OAuth2\Client\Parameter\Scope;

class AccessTokenRequest implements AccessTokenRequestInterface
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
     * @param Scope $scope
     */
    public function setScope(Scope $scope)
    {
        $this->scope = $scope;
    }

    /**
     * @return Scope
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
