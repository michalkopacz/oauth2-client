[![Build Status](https://travis-ci.org/michalkopacz/oauth2-client.svg?branch=develop)](https://travis-ci.org/michalkopacz/oauth2-client)

# Usage

```php
use MostSignificantBit\OAuth2\Client\Client as OAuth2Client;
use MostSignificantBit\OAuth2\Client\Config\Config;
use MostSignificantBit\OAuth2\Client\AccessToken\SuccessfulResponse as AccessTokenSuccessfulResponse;
use MostSignificantBit\OAuth2\Client\Grant\ResourceOwnerPasswordCredentials\AccessTokenRequest;
use MostSignificantBit\OAuth2\Client\Grant\ResourceOwnerPasswordCredentials\ResourceOwnerPasswordCredentialsGrant;
use MostSignificantBit\OAuth2\Client\Parameter\AccessToken;
use MostSignificantBit\OAuth2\Client\Parameter\ExpiresIn;
use MostSignificantBit\OAuth2\Client\Parameter\Password;
use MostSignificantBit\OAuth2\Client\Parameter\RefreshToken;
use MostSignificantBit\OAuth2\Client\Parameter\TokenType;
use MostSignificantBit\OAuth2\Client\Parameter\Username;

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

$oauth2Client = new OAuth2Client($config);

$accessTokenRequest = new AccessTokenRequest(new Username('johndoe'), new Password('A3ddj3w'));

$grant = new ResourceOwnerPasswordCredentialsGrant($accessTokenRequest);

try {
    $accessTokenResponse = $oauth2Client->obtainAccessToken($grant);
} catch (TokenException $exception) {
    //log exception
}
```