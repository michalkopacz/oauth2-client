<?php
namespace GrantType;

use MostSignificantBit\OAuth2\Client\GrantType\ResourceOwnerPasswordCredentialsGrant;
use MostSignificantBit\OAuth2\Client\Parameter\Scope;

class ResourceOwnerPasswordCredentialsGrantTest extends \PHPUnit_Framework_TestCase
{
    public function testGetParams()
    {
        $grant = new ResourceOwnerPasswordCredentialsGrant('johndoe', 'A3ddj3w');
        $grant->setScope(new Scope(array('scope-token-1', 'scope-token-2')));

        $this->assertSame(array(
            'grant_type' => 'password',
            'username' => 'johndoe',
            'password' => 'A3ddj3w',
            'scope' => 'scope-token-1 scope-token-2',
        ), $grant->getParams());
    }
} 