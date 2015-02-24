<?php
namespace MostSignificantBit\OAuth2\Client;

use MostSignificantBit\OAuth2\Client\Assert\Assertion;
use MostSignificantBit\OAuth2\Client\Config\ClientType;
use MostSignificantBit\OAuth2\Client\Config\Config;
use MostSignificantBit\OAuth2\Client\Exception\InvalidArgumentException;
use MostSignificantBit\OAuth2\Client\Exception\TokenException;
use MostSignificantBit\OAuth2\Client\AccessToken\SuccessfulResponse as AccessTokenSuccessfulResponse ;
use MostSignificantBit\OAuth2\Client\AccessToken\SuccessfulResponseInterface;
use MostSignificantBit\OAuth2\Client\Grant\AccessTokenRequestAwareGrantInterface;
use MostSignificantBit\OAuth2\Client\Grant\AuthorizationRequestAwareGrantInterface;
use MostSignificantBit\OAuth2\Client\Authorization\AuthorizationRequestInterface;
use MostSignificantBit\OAuth2\Client\Grant\GrantInterface;
use MostSignificantBit\OAuth2\Client\Http\Response as HttpOAuth2Response;
use MostSignificantBit\OAuth2\Client\Parameter\AccessToken;
use MostSignificantBit\OAuth2\Client\Parameter\ExpiresIn;
use MostSignificantBit\OAuth2\Client\Parameter\RefreshToken;
use MostSignificantBit\OAuth2\Client\Parameter\Scope;
use MostSignificantBit\OAuth2\Client\Http\ClientInterface as HttpClient;
use MostSignificantBit\OAuth2\Client\Parameter\TokenType;
use Zend\Stdlib\ArrayUtils;

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
     * @param AccessTokenRequestAwareGrantInterface $grant
     * @return SuccessfulResponseInterface
     * @throws TokenException
     * @throws InvalidArgumentException
     */
    public function obtainAccessToken(AccessTokenRequestAwareGrantInterface $grant)
    {

        $this->checkIsGrantSupportClientType($grant, new ClientType($this->config->getClientType()));

        $params = array(
            'body' => $grant->getAccessTokenRequest()->getBodyParameters(),
            'credentials' => $this->config->getClientCredentials(),
        );

        $options = array(
            'authentication_type' => $this->config->getClientAuthenticationType(),
            'client_type' => $this->config->getClientType(),
        );

        $response = $this->httpClient->postAccessToken($this->config->getTokenEndpointUri(), $params, $options);

        if ($response->getStatusCode() !== 200) {
            $this->throwTokenException($response);
        }

        return $this->mapToAccessTokenSuccessfulResponse($response->getBody());
    }

    /**
     * @param AuthorizationRequestInterface $authorization
     * @throws InvalidArgumentException
     */
    public function buildAuthorizationRequestUri(AuthorizationRequestAwareGrantInterface $grant)
    {
        $authorizationEndpointUri = $this->config->getAuthorizationEndpointUri();

        Assertion::notNull($authorizationEndpointUri, 'Authorization endpoint uri is required to build authorization request uri.');

        $request = $grant->getAuthorizationRequest();

        $request->setClientId($this->config->getClientId());

        $query = http_build_query($request->getQueryParameters());

        return "{$authorizationEndpointUri}?{$query}";
    }

    protected function checkIsGrantSupportClientType(AccessTokenRequestAwareGrantInterface $grant, ClientType $clientType)
    {
        $isSupported = array_reduce($grant->getSupportedClientTypesForAuthentication(), function($isSupported = false, $supportedClientType) use ($clientType) {
            $isSupported = ($isSupported === true || $supportedClientType->getValue() === $clientType->getValue());
            return $isSupported;
        });

        if (!$isSupported) {
            throw new InvalidArgumentException(sprintf(
                "Unsupported client type '%s' for grant '%s'.",
                $clientType->getValue(),
                $grant->getAccessTokenRequest()->getGrantType()->getValue()
            ),  0, null, null);
        }
    }

    /**
     * @param Response $response
     * @throws Exception\TokenException
     * @throws Exception\InvalidArgumentException
     */
    protected function throwTokenException(HttpOAuth2Response $errorResponse)
    {
        $body = $errorResponse->getBody();

        Assertion::keyExists($body, 'error', 'Error param in response body is required.');

        $error = $body['error'];
        $errorDescription = isset($body['error_description']) ? $body['error_description'] : null;
        $errorUri = isset($body['error_uri']) ? $body['error_uri'] : null;

        throw new TokenException($error, $errorDescription, $errorUri);
    }

    /**
     * @param array $body
     * @throws Exception\InvalidArgumentException
     * @return AccessTokenSuccessfulResponse
     */
    protected function mapToAccessTokenSuccessfulResponse(array $body)
    {
        Assertion::keyExists($body, 'access_token', 'Access token param in body is required.');
        Assertion::keyExists($body, 'token_type', 'Token type param in body is required.');

        $accessTokenSuccessfulResponse = new AccessTokenSuccessfulResponse(
            new AccessToken($body['access_token']),
            new TokenType($body['token_type']));

        if (array_key_exists('expires_in', $body)) {
            $accessTokenSuccessfulResponse->setExpiresIn(new ExpiresIn($body['expires_in']));
        }

        if (array_key_exists('refresh_token', $body)) {
            $accessTokenSuccessfulResponse->setRefreshToken(new RefreshToken($body['refresh_token']));
        }

        if (array_key_exists('scope', $body)) {
            $accessTokenSuccessfulResponse->setScope(Scope::fromParameter($body['scope']));
        }

        return $accessTokenSuccessfulResponse;
    }
} 