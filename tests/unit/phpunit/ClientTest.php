<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 13.02.15
 * Time: 21:20
 */

namespace MostSignificantBit\OAuth2\Client\Tests\Unit;

use MostSignificantBit\OAuth2\Client\Client as OAuth2Client;
use MostSignificantBit\OAuth2\Client\GrantType\ResourceOwnerPasswordCredentialsGrant;
use MostSignificantBit\OAuth2\Client\Response\AccessToken;
use MostSignificantBit\OAuth2\Client\Response\AccessTokenType;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAccessTokenResourceOwnerPasswordCredentialsGrant()
    {
        $httpClient = $this->getMockBuilder('\MostSignificantBit\OAuth2\Client\Http\ClientInterface')
            ->setMethods(array('post'))
            ->getMockForAbstractClass();

        $httpClient->expects($this->once())
                    ->method('post')
                    ->with(
                        $this->equalTo('https://auth.example.com/token'),
                        $this->equalTo(array(
                            'grant_type' => 'password',
                            'username' => 'johndoe',
                            'password' => 'A3ddj3w',
                        )
                    ))
                    ->willReturn(array(
                        'access_token' => '2YotnFZFEjr1zCsicMWpAA',
                        'token_type' => 'Bearer',
                        'expires_in' => 3600,
                        'refresh_token' => 'tGzv3JOkF0XG5Qx2TlKWIA',
                    ));

        $oauth2Client = new OAuth2Client($httpClient, 'https://auth.example.com/token');

        $accessToken = new AccessToken('2YotnFZFEjr1zCsicMWpAA', AccessTokenType::BEARER());
        $accessToken->setExpiresIn(3600);
        $accessToken->setRefreshToken('tGzv3JOkF0XG5Qx2TlKWIA');

        $grantType = new ResourceOwnerPasswordCredentialsGrant('johndoe', 'A3ddj3w');

        $accessTokenResponse = $oauth2Client->obtainAccessToken($grantType);

        $this->assertEquals($accessToken, $accessTokenResponse);
    }
} 