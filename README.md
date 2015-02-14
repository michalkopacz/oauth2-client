# Usage

```php
use MostSignificantBit\OAuth2\Client\Client as OAuth2Client;
use MostSignificantBit\OAuth2\Client\Config\Config;
use MostSignificantBit\OAuth2\Client\GrantType\ResourceOwnerPasswordCredentialsGrant;
use MostSignificantBit\OAuth2\Client\Http\Guzzle5Adapter;

$httpClient = new Guzzle5Adapter(new \GuzzleHttp\Client());

$config = new Config(array(
    'endpoint' => array(
        'token_endpoint_url' => 'http://127.0.0.1:8000/oauth2/token',
    ),
    'client' => array(
        'credentials' => array(
            'client_id' => 's6BhdRkqt3',
            'client_secret' => '7Fjfp0ZBr1KtDRbnfVdmIw',
        ),
    ),
));

$oauth2Client = new OAuth2Client($httpClient, $config);

$grantType = new ResourceOwnerPasswordCredentialsGrant('johndoe', 'A3ddj3w');

try {
    $accessToken = $oauth2Client->obtainAccessToken($grantType);
} catch (TokenException $exception) {
    //log exception
}
```