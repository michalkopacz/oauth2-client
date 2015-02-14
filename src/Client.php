<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 13.02.15
 * Time: 21:19
 */

namespace MostSignificantBit\OAuth2\Client;


use MostSignificantBit\OAuth2\Client\Config\Config;
use MostSignificantBit\OAuth2\Client\GrantType\GrantTypeInterface;
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

    public function obtainAccessToken(GrantTypeInterface $grantType)
    {
        $params = array(
            'body' => $grantType->getParams(),
            'credentials' => $this->config->getClientCredentials(),
        );

        $options = array(
            'authentication_type' => $this->config->getClientAuthenticationType(),
        );

        $response = $this->httpClient->postAccessToken($this->config->getTokenEndpointUrl(), $params, $options);

        return $this->mapToAccessTokenResponse($response);
    }

    protected function mapToAccessTokenResponse(array $response)
    {
        $accessTokenResponse = new AccessToken($response['access_token'], new AccessTokenType($response['token_type']));

        if (array_key_exists('expires_in', $response)) {
            $accessTokenResponse->setExpiresIn($response['expires_in']);
        }

        if (array_key_exists('refresh_token', $response)) {
            $accessTokenResponse->setRefreshToken($response['refresh_token']);
        }

        if (array_key_exists('scope', $response)) {
            $accessTokenResponse->setScope(explode(' ', $response['scope']));
        }

        return $accessTokenResponse;
    }
} 