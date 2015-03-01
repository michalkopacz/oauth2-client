<?php

chdir(dirname(__DIR__));

require "../vendor/autoload.php";

$app = new \Slim\Slim();

$client = new GuzzleHttp\Client(array('defaults'=> array('verify' => false)));
$httpClient = new Ivory\HttpAdapter\GuzzleHttpHttpAdapter($client);

$app->guzzle = $client;

$fb_config = new MostSignificantBit\OAuth2\Client\Config\Config(array(
    'endpoint' => array(
        'token_endpoint_uri' => 'https://graph.facebook.com/oauth/access_token',
        'authorization_endpoint_uri' => 'https://www.facebook.com/dialog/oauth',
    ),
    'client' => array(
        'credentials' => array(
            'client_id' => '348550205343719',
            'client_secret' => '2d08655ea816e81e8c2a07e85790d2c6',
        ),
        'authentication_type' => \MostSignificantBit\OAuth2\Client\Config\AuthenticationType::REQUEST_BODY,
    ),
));

$google_config = new MostSignificantBit\OAuth2\Client\Config\Config(array(
    'endpoint' => array(
        'token_endpoint_uri' => 'https://www.googleapis.com/oauth2/v3/token',
        'authorization_endpoint_uri' => 'https://accounts.google.com/o/oauth2/auth',
    ),
    'client' => array(
        'credentials' => array(
            'client_id' => '9454753967-8kuqt2g4vhln1dpc0p71h6vab934ob2s.apps.googleusercontent.com',
            'client_secret' => 'NbAZfso4_1DsYBnoFF7p6xmp',
        ),
        'authentication_type' => \MostSignificantBit\OAuth2\Client\Config\AuthenticationType::REQUEST_BODY,
    ),
));

$github_config = new MostSignificantBit\OAuth2\Client\Config\Config(array(
    'endpoint' => array(
        'token_endpoint_uri' => 'https://github.com/login/oauth/access_token',
        'authorization_endpoint_uri' => 'https://github.com/login/oauth/authorize',
    ),
    'client' => array(
        'credentials' => array(
            'client_id' => '181c71b4b6b3b2964088',
            'client_secret' => '4d3ec10485f928ae69abff09bd702141f78aa507',
        ),
        'authentication_type' => \MostSignificantBit\OAuth2\Client\Config\AuthenticationType::REQUEST_BODY,
    ),
));

$twitter_config = new MostSignificantBit\OAuth2\Client\Config\Config(array(
    'endpoint' => array(
        'token_endpoint_uri' => 'https://api.twitter.com/oauth2/token',
    ),
    'client' => array(
        'credentials' => array(
            'client_id' => '6QcyVmW349hnUn03Ovu8iqpTt',
            'client_secret' => 'uwLLvIX9Jn7bi4F53PQdp5rqIVYpB28A6dhvxzH8sfyKojNEVu',
        ),
        //'authentication_type' => \MostSignificantBit\OAuth2\Client\Config\AuthenticationType::REQUEST_BODY,
    ),
));

$accessTokenObtainTemplate = new \MostSignificantBit\OAuth2\Client\DefaultAccessTokenObtainTemplate(
    $httpClient,
    $google_config,
    new \MostSignificantBit\OAuth2\Client\AccessTokenHttpResponseJsonDecoder()
);

$app->fb_oauth2Client = new \MostSignificantBit\OAuth2\Client\Client($fb_config);
$app->google_oauth2Client = new \MostSignificantBit\OAuth2\Client\Client($google_config);
$app->google_oauth2Client->setAccessTokenObtainTemplate($accessTokenObtainTemplate);
$app->github_oauth2Client = new \MostSignificantBit\OAuth2\Client\Client($github_config);
$app->twitter_oauth2Client = new \MostSignificantBit\OAuth2\Client\Client($twitter_config);

$app->get('/', function() use ($app) {
    $authorizationRequest = new \MostSignificantBit\OAuth2\Client\Grant\AuthorizationCode\AuthorizationRequest();
    $authorizationRequest->setRedirectUri(new \MostSignificantBit\OAuth2\Client\Parameter\RedirectUri('http://127.0.0.1:8080/callback/facebook'));
    $authorizationRequest->setScope(new \MostSignificantBit\OAuth2\Client\Parameter\Scope(array('public_profile')));

    $grant = new \MostSignificantBit\OAuth2\Client\Grant\AuthorizationCode\AuthorizationCodeGrant(null, $authorizationRequest);
    $fb_authorizationUri = $app->fb_oauth2Client->buildAuthorizationRequestUri($grant);

    $authorizationRequest = new \MostSignificantBit\OAuth2\Client\Grant\AuthorizationCode\AuthorizationRequest();
    $authorizationRequest->setRedirectUri(new \MostSignificantBit\OAuth2\Client\Parameter\RedirectUri('http://127.0.0.1:8080/callback/google'));
    $authorizationRequest->setScope(new \MostSignificantBit\OAuth2\Client\Parameter\Scope(array('profile')));

    $grant = new \MostSignificantBit\OAuth2\Client\Grant\AuthorizationCode\AuthorizationCodeGrant(null, $authorizationRequest);
    $google_authorizationUri = $app->google_oauth2Client->buildAuthorizationRequestUri($grant);

    $authorizationRequest = new \MostSignificantBit\OAuth2\Client\Grant\AuthorizationCode\AuthorizationRequest();
    $authorizationRequest->setRedirectUri(new \MostSignificantBit\OAuth2\Client\Parameter\RedirectUri('http://127.0.0.1:8080/callback/github'));
    $authorizationRequest->setScope(new \MostSignificantBit\OAuth2\Client\Parameter\Scope(array('user')));

    $grant = new \MostSignificantBit\OAuth2\Client\Grant\AuthorizationCode\AuthorizationCodeGrant(null, $authorizationRequest);
    $github_authorizationUri = $app->github_oauth2Client->buildAuthorizationRequestUri($grant);

    $app->render('../views/login.php', array(
        'fb_href' => $fb_authorizationUri,
        'google_href' => $google_authorizationUri,
        'github_href' => $github_authorizationUri,
    ));
});

$app->get('/callback/facebook', function() use ($app) {
    $code = $app->request->params('code');

    $accessTokenRequest = new \MostSignificantBit\OAuth2\Client\Grant\AuthorizationCode\AccessTokenRequest(new \MostSignificantBit\OAuth2\Client\Parameter\Code($code));
    $accessTokenRequest->setRedirectUri(new \MostSignificantBit\OAuth2\Client\Parameter\RedirectUri('http://127.0.0.1:8080/callback/facebook'));

    $grant = new \MostSignificantBit\OAuth2\Client\Grant\AuthorizationCode\AuthorizationCodeGrant($accessTokenRequest);

    $accessTokenResponse = $app->fb_oauth2Client->obtainAccessToken($grant);

    echo $accessTokenResponse->getAccessToken()->getValue();
});

$app->get('/callback/google', function() use ($app) {
    $code = $app->request->params('code');

    $accessTokenRequest = new \MostSignificantBit\OAuth2\Client\Grant\AuthorizationCode\AccessTokenRequest(new \MostSignificantBit\OAuth2\Client\Parameter\Code($code));
    $accessTokenRequest->setRedirectUri(new \MostSignificantBit\OAuth2\Client\Parameter\RedirectUri('http://127.0.0.1:8080/callback/google'));

    $grant = new \MostSignificantBit\OAuth2\Client\Grant\AuthorizationCode\AuthorizationCodeGrant($accessTokenRequest);

    $accessTokenResponse = $app->google_oauth2Client->obtainAccessToken($grant);

    $accessToken = $accessTokenResponse->getAccessToken()->getValue();

    $response = $app->guzzle->get("https://www.googleapis.com/plus/v1/people/me?access_token={$accessToken}");

    $profile = $response->json();

    $app->render('../views/profile.php', array(
        'imageUrl' => $profile['image']['url'],
        'givenName' => $profile['name']['givenName'],
        'familyName' => $profile['name']['familyName'],
    ));
});

$app->get('/callback/github', function() use ($app) {
    $code = $app->request->params('code');

    $accessTokenRequest = new \MostSignificantBit\OAuth2\Client\Grant\AuthorizationCode\AccessTokenRequest(new \MostSignificantBit\OAuth2\Client\Parameter\Code($code));

    $grant = new \MostSignificantBit\OAuth2\Client\Grant\AuthorizationCode\AuthorizationCodeGrant($accessTokenRequest);

    $accessTokenResponse = $app->github_oauth2Client->obtainAccessToken($grant);

    $accessToken = $accessTokenResponse->getAccessToken()->getValue();

    $response = $app->guzzle->get("https://api.github.com/user?access_token={$accessToken}");

    $profile = $response->json();

    $app->render('../views/profile.php', array(
        'imageUrl' => $profile['avatar_url'],
        'givenName' => $profile['login'],
        'familyName' => '',
    ));
});

$app->get('/client/twitter', function() use ($app) {
    $accessTokenRequest = new \MostSignificantBit\OAuth2\Client\Grant\ClientCredentials\AccessTokenRequest();

    $grant = new \MostSignificantBit\OAuth2\Client\Grant\ClientCredentials\ClientCredentialsGrant($accessTokenRequest);

    $accessTokenResponse = $app->twitter_oauth2Client->obtainAccessToken($grant);


    var_dump($accessTokenResponse);

});

$app->run();