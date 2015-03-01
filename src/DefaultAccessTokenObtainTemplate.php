<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client;

use Assert\Assertion;
use Ivory\HttpAdapter\HttpAdapterInterface;
use Ivory\HttpAdapter\Message\Request;
use Ivory\HttpAdapter\Message\ResponseInterface;
use Ivory\HttpAdapter\Message\Stream\StringStream;
use MostSignificantBit\OAuth2\Client\AccessToken\SuccessfulResponseInterface as AccessTokenSuccessfulResponseInterface;
use MostSignificantBit\OAuth2\Client\AccessToken\SuccessfulResponse as AccessTokenSuccessfulResponse;
use MostSignificantBit\OAuth2\Client\Config\AuthenticationType;
use MostSignificantBit\OAuth2\Client\Config\ClientType;
use MostSignificantBit\OAuth2\Client\Config\Config;
use MostSignificantBit\OAuth2\Client\AccessToken\RequestInterface as AccessTokenRequestInterface;
use Ivory\HttpAdapter\Message\RequestInterface;
use MostSignificantBit\OAuth2\Client\Exception\TokenException;
use MostSignificantBit\OAuth2\Client\Parameter\AccessToken;
use MostSignificantBit\OAuth2\Client\Parameter\ExpiresIn;
use MostSignificantBit\OAuth2\Client\Parameter\RefreshToken;
use MostSignificantBit\OAuth2\Client\Parameter\Scope;
use MostSignificantBit\OAuth2\Client\Parameter\TokenType;
use Psr\Http\Message\StreamableInterface;

class DefaultAccessTokenObtainTemplate implements AccessTokenObtainTemplateInterface
{
    /**
     * @var HttpAdapterInterface
     *
     */
    protected $httpClient;
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var AccessTokenHttpResponseDecoderInterface
     */
    protected $httpResponseDecoder;

    public function __construct(HttpAdapterInterface $httpClient, Config $config, AccessTokenHttpResponseDecoderInterface $httpResponseDecoder)
    {
        $this->httpClient = $httpClient;
        $this->config = $config;
        $this->httpResponseDecoder = $httpResponseDecoder;
    }

    /**
     * @return \MostSignificantBit\OAuth2\Client\Config\Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return \Ivory\HttpAdapter\HttpAdapterInterface
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @return \MostSignificantBit\OAuth2\Client\AccessTokenHttpResponseDecoderInterface
     */
    public function getHttpResponseDecoder()
    {
        return $this->httpResponseDecoder;
    }

    /**
     * @param AccessTokenRequestInterface $accessTokenRequest
     * @return RequestInterface
     */
    public function convertAccessTokenRequestToHttpRequest(AccessTokenRequestInterface $accessTokenRequest)
    {
        $request = new Request($this->getConfig()->getTokenEndpointUri(), Request::METHOD_POST);

        $bodyParams = $accessTokenRequest->getBodyParameters();

        $this->setClientAuthenticationData($request, $bodyParams);

        $request->addHeader('Content-Type', 'application/x-www-form-urlencoded');
        $request->addHeader('Accept', $this->getHttpResponseDecoder()->getMimeType());

        $request->setBody($this->buildRequestBodyInUrlEncodedFormat($bodyParams));

        return $request;
    }

    /**
     * @param RequestInterface $httpRequest
     * @return ResponseInterface
     */
    public function obtainAccessTokenHttpResponse(RequestInterface $httpRequest)
    {
        return $this->getHttpClient()->sendRequest($httpRequest);
    }

    /**
     * @param ResponseInterface $httpResponse
     * @return bool
     */
    public function isSuccessfulResponse(ResponseInterface $httpResponse)
    {
        return $httpResponse->getStatusCode() === 200;
    }

    /**
     * @param ResponseInterface $httpResponse
     * @return AccessTokenSuccessfulResponseInterface
     */
    public function convertHttpResponseToAccessTokenSuccessfulResponse(ResponseInterface $httpResponse)
    {
        $body = $this->getHttpResponseDecoder()->decode($httpResponse);

        Assertion::keyExists($body, 'access_token', 'Access token param in body is required.');
        Assertion::keyExists($body, 'token_type', 'Token type param in body is required.');

        $accessTokenSuccessfulResponse = new AccessTokenSuccessfulResponse(
            new AccessToken($body['access_token']),
            new TokenType(ucfirst(strtolower($body['token_type'])))
        );

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

    /**
     * @param ResponseInterface $httpResponse
     * @throws TokenException
     */
    public function throwTokenException(ResponseInterface $httpResponse)
    {
        $body = $this->getHttpResponseDecoder()->decode($httpResponse);

        Assertion::keyExists($body, 'error', 'Error param in response body is required.');

        $error = $body['error'];
        $errorDescription = isset($body['error_description']) ? $body['error_description'] : null;
        $errorUri = isset($body['error_uri']) ? $body['error_uri'] : null;

        throw new TokenException($error, $errorDescription, $errorUri);
    }

    protected function setClientAuthenticationData(RequestInterface $request, array &$bodyParams)
    {
        switch ($this->config->getClientAuthenticationType()) {
            case AuthenticationType::REQUEST_BODY:
                $bodyParams['client_id'] = $this->config->getClientId();

                if ($this->config->getClientType() === ClientType::CONFIDENTIAL_TYPE) {
                    $bodyParams['client_secret'] = $this->config->getClientSecret();
                }

                break;
            case AuthenticationType::HTTP_BASIC:
                $request->addHeader('Authorization', $this->getBasicAuth());
                break;
            default:
                throw new \Exception('Unrecognized client authentication type.');
        }
    }

    protected function getBasicAuth()
    {
        $userId   = $this->config->getClientId();
        $password = $this->config->getClientSecret();

        return "Basic " . base64_encode("$userId:$password");
    }

    /**
     * @param array $bodyParams
     * @return StreamableInterface
     */
    protected function buildRequestBodyInUrlEncodedFormat(array $bodyParams)
    {
        $body =  http_build_query($bodyParams, null, '&');

        return new StringStream($body);
    }
}