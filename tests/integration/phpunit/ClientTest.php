<?php

namespace MostSignificantBit\OAuth2\Client\Tests\Integration;

use MostSignificantBit\OAuth2\Client\Client as OAuth2Client;
use MostSignificantBit\OAuth2\Client\GrantType\ResourceOwnerPasswordCredentialsGrant;
use MostSignificantBit\OAuth2\Client\Response\AccessToken;
use MostSignificantBit\OAuth2\Client\Response\AccessTokenType;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAccessTokenResourceOwnerPasswordCredentialsGrant()
    {
        $httpClient =

        $oauth2Client = new OAuth2Client($httpClient, 'https://auth.example.com/token');

        $accessToken = new AccessToken('2YotnFZFEjr1zCsicMWpAA', AccessTokenType::BEARER());
        $accessToken->setExpiresIn(3600);
        $accessToken->setRefreshToken('tGzv3JOkF0XG5Qx2TlKWIA');

        $grantType = new ResourceOwnerPasswordCredentialsGrant('johndoe', 'A3ddj3w');

        $accessTokenResponse = $oauth2Client->obtainAccessToken($grantType);

        $this->assertEquals($accessToken, $accessTokenResponse);
    }
} 