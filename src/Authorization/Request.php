<?php
namespace MostSignificantBit\OAuth2\Client\Authorization;

use MostSignificantBit\OAuth2\Client\Assert\Assertion;
use MostSignificantBit\OAuth2\Client\Parameter\Scope;

class Request implements RequestInterface
{
    /**
     * OAuth2: REQUIRED
     *
     * @var ResponseType
     */
    protected $responseType;

    /**
     * The client identifier.
     *
     * OAuth2: REQUIRED
     *
     * @var string
     */
    protected $clientId;

    /**
     * OAuth2: OPTIONAL
     *
     * @var string
     */
    protected $redirectUri;

    /**
     * The scope of the access request.
     *
     * OAuth2: OPTIONAL
     *
     * @var Scope
     */
    protected $scope;

    /**
     * An opaque value used by the client to maintain state between the request and callback.
     *
     * OAuth2: RECOMMENDED
     *
     * @var string
     */
    protected $state;

    /**
     * ClientId is required, but we set it in \MostSignificantBit\OAuth2\Client\Client from config;
     *
     * @param ResponseType $responseType
     */
    public function __construct(ResponseType $responseType)
    {
        $this->setResponseType($responseType);
    }

    /**
     * @param string $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param string $redirectUri
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }

    /**
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * @param ResponseType $responseType
     */
    public function setResponseType($responseType)
    {
        $this->responseType = $responseType;
    }

    /**
     * @return ResponseType
     */
    public function getResponseType()
    {
        return $this->responseType;
    }

    /**
     * @param Scope $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
    }

    /**
     * @return Scope
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return array
     */
    public function getQueryParams()
    {
        $clientId = $this->getClientId();
        Assertion::notNull($clientId, 'clientId is required');

        $params = array(
            'response_type' => $this->getResponseType()->getValue(),
            'client_id'     => $clientId,
        );

        if ($this->getRedirectUri() !== null) {
            $params['redirect_uri'] = $this->getRedirectUri();
        }

        if ($this->getScope() !== null) {
            $params['scope'] = $this->getScope()->getScopeParam();
        }

        if ($this->getState() !== null) {
            $params['state'] = $this->getState();
        }

        return $params;
    }
}