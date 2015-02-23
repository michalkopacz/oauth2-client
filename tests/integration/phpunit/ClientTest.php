<?php

namespace MostSignificantBit\OAuth2\Client\Tests\Integration;

use MostSignificantBit\OAuth2\Client\Client as OAuth2Client;
use MostSignificantBit\OAuth2\Client\Config\Config;
use MostSignificantBit\OAuth2\Client\Grant\AccessToken\SuccessfulResponse as AccessTokenSuccessfulResponse;
use MostSignificantBit\OAuth2\Client\Grant\ResourceOwnerPasswordCredentials\AccessTokenRequest;
use MostSignificantBit\OAuth2\Client\Grant\ResourceOwnerPasswordCredentials\ResourceOwnerPasswordCredentialsGrant;
use MostSignificantBit\OAuth2\Client\Http\Guzzle5Adapter;
use MostSignificantBit\OAuth2\Client\Parameter\AccessToken;
use MostSignificantBit\OAuth2\Client\Parameter\ExpiresIn;
use MostSignificantBit\OAuth2\Client\Parameter\Password;
use MostSignificantBit\OAuth2\Client\Parameter\RefreshToken;
use MostSignificantBit\OAuth2\Client\Parameter\TokenType;
use MostSignificantBit\OAuth2\Client\Parameter\Username;
use Symfony\Component\Process\Process;

/**
 * @group integration
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Process
     */
    protected static $serverProcess;

    public static function setUpBeforeClass()
    {
        $testDir = dirname(dirname(__DIR__));

        $cmd = "php -S 127.0.0.1:8000 -t {$testDir}/server/web {$testDir}/server/web/index.php";

        self::$serverProcess = new Process($cmd);
        self::$serverProcess->start();
    }

    public function testGetAccessTokenResourceOwnerPasswordCredentialsGrant()
    {
        $httpClient = new Guzzle5Adapter(new \GuzzleHttp\Client());

        $config = new Config(array(
            'endpoint' => array(
                'token_endpoint_uri' => 'http://127.0.0.1:8000/oauth2/token',
            ),
            'client' => array(
                'credentials' => array(
                    'client_id' => 's6BhdRkqt3',
                    'client_secret' => '7Fjfp0ZBr1KtDRbnfVdmIw',
                ),
            ),
        ));

        $oauth2Client = new OAuth2Client($httpClient, $config);

        $accessTokenExpectedResponse = new AccessTokenSuccessfulResponse(new AccessToken('2YotnFZFEjr1zCsicMWpAA'), TokenType::BEARER());
        $accessTokenExpectedResponse->setExpiresIn(new ExpiresIn(3600));
        $accessTokenExpectedResponse->setRefreshToken(new RefreshToken('tGzv3JOkF0XG5Qx2TlKWIA'));

        $accessTokenRequest = new AccessTokenRequest(new Username('johndoe'), new Password('A3ddj3w'));

        $grantType = new ResourceOwnerPasswordCredentialsGrant($accessTokenRequest);

        $accessTokenResponse = $oauth2Client->obtainAccessToken($grantType);

        $this->assertEquals($accessTokenExpectedResponse, $accessTokenResponse);
    }

    public static function tearDownAfterClass()
    {
        self::$serverProcess->stop();
    }
} 