<?php
namespace GrantType;

use MostSignificantBit\OAuth2\Client\GrantType\ResourceOwnerPasswordCredentialsGrant;

class ResourceOwnerPasswordCredentialsGrantTest extends \PHPUnit_Framework_TestCase
{
    public function testGetParams()
    {
        $grant = new ResourceOwnerPasswordCredentialsGrant('johndoe', 'A3ddj3w');
        $grant->setScope(array('scope1', 'scope2'));

        $this->assertSame(array(
            'grant_type' => 'password',
            'username' => 'johndoe',
            'password' => 'A3ddj3w',
            'scope' => 'scope1 scope2',
        ), $grant->getParams());
    }
} 