<?php
namespace MostSignificantBit\OAuth2\Client;

use MostSignificantBit\OAuth2\Client\Assert\Assertion;
use MostSignificantBit\OAuth2\Client\Config\Config;
use MostSignificantBit\OAuth2\Client\Exception\InvalidArgumentException;
use MostSignificantBit\OAuth2\Client\Exception\TokenException;
use MostSignificantBit\OAuth2\Client\Grant\AuthorizationRequestInterface;
use MostSignificantBit\OAuth2\Client\GrantType\GrantTypeInterface;
use MostSignificantBit\OAuth2\Client\Http\Response;
use MostSignificantBit\OAuth2\Client\Response\AccessToken;
use MostSignificantBit\OAuth2\Client\Response\AccessTokenType;
use MostSignificantBit\OAuth2\Client\Http\ClientInterface as HttpClient;

class Client
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var Config
     */
    protected $config;

    public function __construct(HttpClient $httpClient, Config $config)
    {
        $this->httpClient = $httpClient;
        $this->config = $config;
    }

    /**
     * @param GrantTypeInterface $grantType
     * @return AccessToken
     * @throws TokenException
     * @throws InvalidArgumentException
     */
    public function obtainAccessToken(GrantTypeInterface $grantType)
    {
        $params = array(
            'body' => $grantType->getParams(),
            'credentials' => $this->config->getClientCredentials(),
        );

        $options = array(
            'authentication_type' => $this->config->getClientAuthenticationType(),
        );

        $response = $this->httpClient->postAccessToken($this->config->getTokenEndpointUri(), $params, $options);

        if ($response->getStatusCode() !== 200) {
            $this->throwTokenException($response);
        }

        return $this->mapToAccessTokenResponse($response->getBody());
    }

    /**
     * @param AuthorizationRequestInterface $authorization
     * @throws InvalidArgumentException
     */
    public function buildAuthorizationRequestUri(AuthorizationRequestInterface $authorization)
    {
        $authorizationEndpointUri = $this->config->getAuthorizationEndpointUri();

        Assertion::notNull($authorizationEndpointUri, 'Authorization endpoint uri is required to build uri.');

        $authorization->setClientId($this->config->getClientId());

        $query = http_build_query($authorization->getQueryParameters());

        return "{$authorizationEndpointUri}?{$query}";
    }

    /**
     * @param Response $response
     * @throws Exception\TokenException
     * @throws Exception\InvalidArgumentException
     */
    protected function throwTokenException(Response $response)
    {
        $body = $response->getBody();

        Assertion::keyExists($body, 'error', 'Error param in response body is required.');

        $error = $body['error'];
        $errorDescription = isset($body['error_description']) ? $body['error_description'] : null;
        $errorUri = isset($body['error_uri']) ? $body['error_uri'] : null;

        throw new TokenException($error, $errorDescription, $errorUri);
    }

    /**
     * @param array $body
     * @throws Exception\InvalidArgumentException
     * @return AccessToken
     */
    protected function mapToAccessTokenResponse(array $body)
    {
        Assertion::keyExists($body, 'access_token', 'Access token param in body is required.');
        Assertion::keyExists($body, 'token_type', 'Token type param in body is required.');

        $accessTokenResponse = new AccessToken($body['access_token'], new AccessTokenType($body['token_type']));

        if (array_key_exists('expires_in', $body)) {
            $accessTokenResponse->setExpiresIn($body['expires_in']);
        }

        if (array_key_exists('refresh_token', $body)) {
            $accessTokenResponse->setRefreshToken($body['refresh_token']);
        }

        if (array_key_exists('scope', $body)) {
            $accessTokenResponse->setScope(explode(' ', $body['scope']));
        }

        return $accessTokenResponse;
    }
} 