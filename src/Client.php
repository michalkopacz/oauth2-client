<?php
namespace MostSignificantBit\OAuth2\Client;

use Ivory\HttpAdapter\CurlHttpAdapter;
use MostSignificantBit\OAuth2\Client\Assert\Assertion;
use MostSignificantBit\OAuth2\Client\Config\ClientType;
use MostSignificantBit\OAuth2\Client\Config\Config;
use MostSignificantBit\OAuth2\Client\Exception\InvalidArgumentException;
use MostSignificantBit\OAuth2\Client\Exception\TokenException;
use MostSignificantBit\OAuth2\Client\AccessToken\SuccessfulResponseInterface as AccessTokenSuccessfulResponseInterface;
use MostSignificantBit\OAuth2\Client\Grant\AccessTokenRequestAwareGrantInterface;
use MostSignificantBit\OAuth2\Client\Grant\AuthorizationRequestAwareGrantInterface;
use MostSignificantBit\OAuth2\Client\Authorization\AuthorizationRequestInterface;

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

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

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

        $httpResponse = $accessTokenObtainTemplate->obtainAccessTokenHttpResponse($httpRequest);

        if (!$accessTokenObtainTemplate->isSuccessfulResponse($httpResponse)){
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
            ), 0, null, null);
        }
    }

    /**
     * @return AccessTokenObtainTemplateInterface|DefaultAccessTokenObtainTemplate
     */
    protected function getAccessTokenObtainTemplate()
    {
        if ($this->accessTokenObtainTemplate === null) {
            $this->accessTokenObtainTemplate = new DefaultAccessTokenObtainTemplate(
                new CurlHttpAdapter(),
                $this->config,
                new AccessTokenHttpResponseJsonDecoder()
            );
        }

        return $this->accessTokenObtainTemplate;
    }
}
