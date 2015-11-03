<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Grant\ResourceOwnerPasswordCredentials;

use MostSignificantBit\OAuth2\Client\AccessToken\RequestInterface as AccessTokenRequestInterface;
use MostSignificantBit\OAuth2\Client\Parameter\GrantType;
use MostSignificantBit\OAuth2\Client\Parameter\Password;
use MostSignificantBit\OAuth2\Client\Parameter\Scope;
use MostSignificantBit\OAuth2\Client\Parameter\Username;

class AccessTokenRequest implements AccessTokenRequestInterface
{
    /**
     * OAuth2: REQUIRED
     *
     * @var Username
     */
    protected $username;

    /**
     * OAuth2: REQUIRED
     *
     * @var Password
     */
    protected $password;

    /**
     * OAuth2: OPTIONAL
     *
     * @var Scope
     */
    protected $scope;

    /**
     * @param Username $username
     * @param Password $password
     */
    public function __construct(Username $username, Password $password)
    {
        $this->setUsername($username);
        $this->setPassword($password);
    }

    /**
     * @return GrantType
     */
    public function getGrantType()
    {
        return GrantType::PASSWORD();
    }

    /**
     * @param Username $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return Username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param Password $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return Password
     */
    public function getPassword()
    {
        return $this->password;
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
        $params = array(
            'grant_type' => $this->getGrantType()->getValue(),
            'username' => $this->getUsername()->getValue(),
            'password' => $this->getPassword()->getValue(),
        );

        if ($this->getScope() !== null) {
            $params['scope'] = $this->getScope()->getScopeParameter();
        }

        return $params;
    }
}
