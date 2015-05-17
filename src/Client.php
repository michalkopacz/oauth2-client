<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */
namespace MostSignificantBit\OAuth2\Client;

use Curl\Curl;
use MostSignificantBit\OAuth2\Client\Assert\Assertion;
use MostSignificantBit\OAuth2\Client\Config\ClientType;
use MostSignificantBit\OAuth2\Client\Config\Config;
use MostSignificantBit\OAuth2\Client\Exception\InvalidArgumentException;
use MostSignificantBit\OAuth2\Client\Exception\TokenException;
use MostSignificantBit\OAuth2\Client\AccessToken\SuccessfulResponseInterface as AccessTokenSuccessfulResponseInterface;
use MostSignificantBit\OAuth2\Client\Grant\AccessTokenRequestAwareGrantInterface;
use MostSignificantBit\OAuth2\Client\Grant\AuthorizationRequestAwareGrantInterface;
use MostSignificantBit\OAuth2\Client\Authorization\AuthorizationRequestInterface;
use MostSignificantBit\OAuth2\Client\Http\Decoder\AccessTokenHttpResponseJsonDecoder;
use MostSignificantBit\OAuth2\Client\Http\DefaultClient;

/**
 * OAuth2 client.
 */
class Client
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var AccessTokenObtainTemplateInterface
     */
    protected $accessTokenObtainTemplate;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param AccessTokenObtainTemplateInterface $accessTokenObtainTemplate
     */
    public function setAccessTokenObtainTemplate(AccessTokenObtainTemplateInterface $accessTokenObtainTemplate)
    {
        $this->accessTokenObtainTemplate = $accessTokenObtainTemplate;
    }

    /**
     * @param AccessTokenRequestAwareGrantInterface $grant
     * @return AccessTokenSuccessfulResponseInterface
     * @throws TokenException
     * @throws InvalidArgumentException
     */
    public function obtainAccessToken(AccessTokenRequestAwareGrantInterface $grant)
    {
        $this->checkIsGrantSupportClientType($grant, new ClientType($this->config->getClientType()));

        $accessTokenObtainTemplate = $this->getAccessTokenObtainTemplate();

        $accessTokenRequest = $grant->getAccessTokenRequest();

        $httpRequest = $accessTokenObtainTemplate->convertAccessTokenRequestToHttpRequest($accessTokenRequest);

        $httpResponse = $accessTokenObtainTemplate->sendHttpRequest($httpRequest);

        if (!$accessTokenObtainTemplate->isSuccessfulResponse($httpResponse)) {
            $accessTokenObtainTemplate->throwTokenException($httpResponse);
        }

        $accessTokenSuccessfulResponse = $accessTokenObtainTemplate->convertHttpResponseToAccessTokenSuccessfulResponse($httpResponse);

        return $accessTokenSuccessfulResponse;
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

    /**
     * @param AccessTokenRequestAwareGrantInterface $grant
     * @param ClientType                            $clientType
     */
    protected function checkIsGrantSupportClientType(AccessTokenRequestAwareGrantInterface $grant, ClientType $clientType)
    {
        $isSupported = array_reduce(
            $grant->getSupportedClientTypesForAuthentication(),
            function($isSupported = false, $supportedClientType) use ($clientType) {
                $isSupported = ($isSupported === true || $supportedClientType->getValue() === $clientType->getValue());
                return $isSupported;
            }
        );

        if (!$isSupported) {
            throw new InvalidArgumentException(
                sprintf(
                    "Unsupported client type '%s' for grant '%s'.",
                    $clientType->getValue(),
                    $grant->getAccessTokenRequest()->getGrantType()->getValue()
                ),
                0,
                null,
                null
            );
        }
    }

    /**
     * @return AccessTokenObtainTemplateInterface|DefaultAccessTokenObtainTemplate
     */
    protected function getAccessTokenObtainTemplate()
    {
        if ($this->accessTokenObtainTemplate === null) {
            $curlClient = new Curl();
            $curlClient->setOpt(CURLOPT_SSL_VERIFYPEER, 0);
            $curlClient->setOpt(CURLOPT_SSL_VERIFYHOST, 0);

            $this->accessTokenObtainTemplate = new DefaultAccessTokenObtainTemplate(
                new DefaultClient($curlClient),
                $this->config,
                new AccessTokenHttpResponseJsonDecoder()
            );
        }

        return $this->accessTokenObtainTemplate;
    }
}
