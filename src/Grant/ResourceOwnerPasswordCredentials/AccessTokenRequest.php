<?php
namespace MostSignificantBit\OAuth2\Client\Grant\ResourceOwnerPasswordCredentials;

use MostSignificantBit\OAuth2\Client\AccessToken\AbstractRequest as AbstractAccessTokenRequest;
use MostSignificantBit\OAuth2\Client\Parameter\GrantType;
use MostSignificantBit\OAuth2\Client\Parameter\Password;
use MostSignificantBit\OAuth2\Client\Parameter\Scope;
use MostSignificantBit\OAuth2\Client\Parameter\Username;

class AccessTokenRequest extends AbstractAccessTokenRequest
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
     * @param \MostSignificantBit\OAuth2\Client\Parameter\Username $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return \MostSignificantBit\OAuth2\Client\Parameter\Username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param \MostSignificantBit\OAuth2\Client\Parameter\Password $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return \MostSignificantBit\OAuth2\Client\Parameter\Password
     */
    public function getPassword()
    {
        return $this->password;
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