<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 13.02.15
 * Time: 21:20
 */

namespace MostSignificantBit\OAuth2\Client\Tests;

use MostSignificantBit\OAuth2\Client\Client as OAuth2Client;
use MostSignificantBit\OAuth2\Client\Response\AccessToken;
use MostSignificantBit\OAuth2\Client\Response\AccessTokenType;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var OAuth2Client
     */
    protected $oauth2Client;

    public function setUp()
    {
        $this->oauth2Client = new OAuth2Client();
    }

    public function testGetAccessTokenResourceOwnerPasswordCredentialsGrant()
    {
        $accessToken = new AccessToken('abcdef12345', AccessTokenType::BEARER());

        $accessTokenResponse = $this->oauth2Client->obtainAccessToken();

        $this->assertEquals($accessToken, $accessTokenResponse);
    }
} 