<?php
namespace MostSignificantBit\OAuth2\Client\Tests\Unit;

use MostSignificantBit\OAuth2\Client\Client as OAuth2Client;
use MostSignificantBit\OAuth2\Client\Config\Config;
use MostSignificantBit\OAuth2\Client\Exception\TokenException;
use MostSignificantBit\OAuth2\Client\GrantType\ResourceOwnerPasswordCredentialsGrant;
use MostSignificantBit\OAuth2\Client\Http\Response;
use MostSignificantBit\OAuth2\Client\Response\AccessToken;
use MostSignificantBit\OAuth2\Client\Response\AccessTokenType;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAccessTokenResourceOwnerPasswordCredentialsGrant()
    {
        $httpClient = $this->getMockBuilder('\MostSignificantBit\OAuth2\Client\Http\ClientInterface')
            ->setMethods(array('postAccessToken'))
            ->getMockForAbstractClass();

        $oauth2Response = new Response();
        $oauth2Response->setStatusCode(200);
        $oauth2Response->setBody(array(
            'access_token' => '2YotnFZFEjr1zCsicMWpAA',
            'token_type' => 'Bearer',
            'expires_in' => 3600,
            'refresh_token' => 'tGzv3JOkF0XG5Qx2TlKWIA',
            'scope' => 'example1 example2',
        ));

        $httpClient->expects($this->once())
                    ->method('postAccessToken')
                    ->with(
                        $this->equalTo('https://auth.example.com/token'),
                        $this->equalTo(array(
                            'body' => array(
                                'grant_type' => 'password',
                                'username' => 'johndoe',
                                'password' => 'A3ddj3w',
                            ),
                            'credentials' => array(
                                'client_id' => 's6BhdRkqt3',
                                'client_secret' => '7Fjfp0ZBr1KtDRbnfVdmIw',
                            )
                        )),
                        $this->equalTo(array(
                            'authentication_type' => Config::CLIENT_HTTP_BASIC_AUTHENTICATION_TYPE,
                        ))
                    )
                    ->willReturn($oauth2Response);

        $config = new Config(array(
            'endpoint' => array(
               'token_endpoint_url' => 'https://auth.example.com/token',
             ),
            'client' => array(
                'credentials' => array(
                    'client_id' => 's6BhdRkqt3',
                    'client_secret' => '7Fjfp0ZBr1KtDRbnfVdmIw',
                ),
            ),
        ));

        $oauth2Client = new OAuth2Client($httpClient, $config);

        $accessToken = new AccessToken('2YotnFZFEjr1zCsicMWpAA', AccessTokenType::BEARER());
        $accessToken->setExpiresIn(3600);
        $accessToken->setRefreshToken('tGzv3JOkF0XG5Qx2TlKWIA');
        $accessToken->setScope(array('example1', 'example2'));

        $grantType = new ResourceOwnerPasswordCredentialsGrant('johndoe', 'A3ddj3w');

        $accessTokenResponse = $oauth2Client->obtainAccessToken($grantType);

        $this->assertEquals($accessToken, $accessTokenResponse);
    }

    /**
     * @expectedException \MostSignificantBit\OAuth2\Client\Exception\TokenException
     * @expectedExceptionCode 1
     * @expectedExceptionMessage Invalid request
     */
    public function testInvalidRequestAccessTokenResourceOwnerPasswordCredentialsGrant()
    {
        $httpClient = $this->getMockBuilder('\MostSignificantBit\OAuth2\Client\Http\ClientInterface')
            ->setMethods(array('postAccessToken'))
            ->getMockForAbstractClass();

        $oauth2Response = new Response();
        $oauth2Response->setStatusCode(400);
        $oauth2Response->setBody(array(
            'error' => 'invalid_request',
            'error_description'=> 'Invalid request',
            'error_uri' => 'https://auth.example.com/oauth2/errors/invalid_request'
        ));

        $httpClient->expects($this->once())
            ->method('postAccessToken')
            ->with(
                $this->equalTo('https://auth.example.com/token'),
                $this->equalTo(array(
                    'body' => array(
                        'grant_type' => 'password',
                        'username' => 123456,
                        'password' => 'A3ddj3w',
                    ),
                    'credentials' => array(
                        'client_id' => 's6BhdRkqt3',
                        'client_secret' => '7Fjfp0ZBr1KtDRbnfVdmIw',
                    )
                )),
                $this->equalTo(array(
                    'authentication_type' => Config::CLIENT_HTTP_BASIC_AUTHENTICATION_TYPE,
                ))
            )
            ->willReturn($oauth2Response);

        $config = new Config(array(
            'endpoint' => array(
                'token_endpoint_url' => 'https://auth.example.com/token',
            ),
            'client' => array(
                'credentials' => array(
                    'client_id' => 's6BhdRkqt3',
                    'client_secret' => '7Fjfp0ZBr1KtDRbnfVdmIw',
                ),
            ),
        ));

        $oauth2Client = new OAuth2Client($httpClient, $config);

        $grantType = new ResourceOwnerPasswordCredentialsGrant(123456, 'A3ddj3w');

        try {
            $oauth2Client->obtainAccessToken($grantType);
        } catch (TokenException $exception) {
            $this->assertSame('https://auth.example.com/oauth2/errors/invalid_request', $exception->getErrorUri());

            throw $exception;
        }
    }
} 