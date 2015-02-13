<?php
namespace MostSignificantBit\OAuth2\Client\GrantType;

class ResourceOwnerPasswordCredentialsGrant implements GrantTypeInterface
{
    const GRANT_TYPE = 'password';

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var array
     */
    protected $scope;

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param array $scope
     */
    public function setScope(array $scope)
    {
        $this->scope = $scope;
    }

    /**
     * @return array
     */
    public function getScope()
    {
        return $this->scope;
    }

    public function getGrantType()
    {
        return self::GRANT_TYPE;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $params = array(
            'grant_type' => $this->getGrantType(),
            'username' => $this->getUsername(),
            'password' => $this->getPassword(),
        );

        $scope = $this->getScope();

        if ($scope !== null) {
            $params['scope'] = implode(' ', $scope);
        }

        return $params;
    }
}