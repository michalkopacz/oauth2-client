<?php
namespace MostSignificantBit\OAuth2\Client\Tests\Unit;

use MostSignificantBit\OAuth2\Client\Config\AuthenticationType;
use MostSignificantBit\OAuth2\Client\Config\ClientType;
use MostSignificantBit\OAuth2\Client\Config\Config;
use MostSignificantBit\OAuth2\Client\Client as OAuth2Client;
use MostSignificantBit\OAuth2\Client\AccessToken\SuccessfulResponse as AccessTokenSuccessfulResponse;
use MostSignificantBit\OAuth2\Client\Exception\TokenException;
use MostSignificantBit\OAuth2\Client\Grant\AuthorizationCode\AuthorizationCodeGrant;
use MostSignificantBit\OAuth2\Client\Grant\ResourceOwnerPasswordCredentials\AccessTokenRequest;
use MostSignificantBit\OAuth2\Client\Grant\ResourceOwnerPasswordCredentials\ResourceOwnerPasswordCredentialsGrant;
use MostSignificantBit\OAuth2\Client\Grant\AuthorizationCode\AuthorizationRequest;
use MostSignificantBit\OAuth2\Client\Parameter\AccessToken;
use MostSignificantBit\OAuth2\Client\Parameter\ExpiresIn;
use MostSignificantBit\OAuth2\Client\Parameter\Password;
use MostSignificantBit\OAuth2\Client\Parameter\RefreshToken;
use MostSignificantBit\OAuth2\Client\Parameter\Scope;
use MostSignificantBit\OAuth2\Client\Parameter\TokenType;
use MostSignificantBit\OAuth2\Client\Parameter\Username;

/**
 * @group unit
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAuthorizationRequestUriForCodeResponseType()
    {
        $config = $this->getConfig();

        $oauth2Client = new OAuth2Client($config);

        $authorizationRequest = new AuthorizationRequest();
        $authorizationRequest->setScope(new Scope(array('scope-token-1', 'scope-token-2')));

        $grant = new AuthorizationCodeGrant(null, $authorizationRequest);

        $uri = $oauth2Client->buildAuthorizationRequestUri($grant);

        $this->assertSame('https://auth.example.com/authorize?response_type=code&client_id=s6BhdRkqt3&scope=scope-token-1+scope-token-2', $uri);
    }

    protected function getConfig()
    {
        return new Config(array(
            'endpoint' => array(
                'token_endpoint_uri' => 'https://auth.example.com/token',
                'authorization_endpoint_uri' => 'https://auth.example.com/authorize',
            ),
            'client' => array(
                'credentials' => array(
                    'client_id' => 's6BhdRkqt3',
                    'client_secret' => '7Fjfp0ZBr1KtDRbnfVdmIw',
                ),
            ),
        ));
    }
} 