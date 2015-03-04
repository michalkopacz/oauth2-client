<?php
namespace MostSignificantBit\OAuth2\Client\Tests\Unit\Grant\ResourceOwnerPasswordCredentials;

use MostSignificantBit\OAuth2\Client\Grant\ResourceOwnerPasswordCredentials\AccessTokenRequest;
use MostSignificantBit\OAuth2\Client\Grant\ResourceOwnerPasswordCredentials\ResourceOwnerPasswordCredentialsGrant;
use MostSignificantBit\OAuth2\Client\Parameter\Password;
use MostSignificantBit\OAuth2\Client\Parameter\Username;

/**
 * @group unit
 */
class ResourceOwnerPasswordCredentialsGrantTest extends \PHPUnit_Framework_TestCase
{
    public function testSetAccessTokenRequestByConstructor()
    {
        $accessTokenRequest = new AccessTokenRequest(new Username('johndoe'), new Password('A3ddj3w'));

        $grant = new ResourceOwnerPasswordCredentialsGrant($accessTokenRequest);

        $this->assertSame($accessTokenRequest, $grant->getAccessTokenRequest());
    }

    public function testSetAccessTokenRequestBySetter()
    {
        $accessTokenRequest = new AccessTokenRequest(new Username('johndoe'), new Password('A3ddj3w'));

        $grant = new ResourceOwnerPasswordCredentialsGrant();
        $grant->setAccessTokenRequest($accessTokenRequest);

        $this->assertSame($accessTokenRequest, $grant->getAccessTokenRequest());
    }
} 