<?php

namespace MostSignificantBit\OAuth2\Client\Tests\Integration;

use MostSignificantBit\OAuth2\Client\Client as OAuth2Client;
use MostSignificantBit\OAuth2\Client\GrantType\ResourceOwnerPasswordCredentialsGrant;
use MostSignificantBit\OAuth2\Client\Http\Guzzle5Adapter;
use MostSignificantBit\OAuth2\Client\Response\AccessToken;
use MostSignificantBit\OAuth2\Client\Response\AccessTokenType;
use Symfony\Component\Process\Process;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Process
     */
    protected static $serverProcess;

    public static function setUpBeforeClass()
    {
        $dir = dirname(dirname(__DIR__));

        $cmd = "php -S localhost:8000 -t {$dir}/server/web {$dir}/server/web/index.php";

        self::$serverProcess = new Process($cmd);
        self::$serverProcess->start();
    }

    public function testGetAccessTokenResourceOwnerPasswordCredentialsGrant()
    {
        $httpClient = new Guzzle5Adapter(new \GuzzleHttp\Client());

        $oauth2Client = new OAuth2Client($httpClient, 'http://127.0.0.1:8000/oauth2/token');

        $accessToken = new AccessToken('2YotnFZFEjr1zCsicMWpAA', AccessTokenType::BEARER());
        $accessToken->setExpiresIn(3600);
        $accessToken->setRefreshToken('tGzv3JOkF0XG5Qx2TlKWIA');

        $grantType = new ResourceOwnerPasswordCredentialsGrant('johndoe', 'A3ddj3w');

        $accessTokenResponse = $oauth2Client->obtainAccessToken($grantType);

        $this->assertEquals($accessToken, $accessTokenResponse);
    }

    public static function tearDownAfterClass()
    {
        self::$serverProcess->stop();
    }
} 