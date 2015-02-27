<?php
namespace MostSignificantBit\OAuth2\Client\Authorization;

use MostSignificantBit\OAuth2\Client\Assert\Assertion;
use MostSignificantBit\OAuth2\Client\Parameter\RedirectUri;
use MostSignificantBit\OAuth2\Client\Parameter\Scope;
use MostSignificantBit\OAuth2\Client\Parameter\State;

abstract class AbstractAuthorizationRequest implements AuthorizationRequestInterface
{
    /**
     * OAuth2: REQUIRED
     *
     * @var string
     */
    protected $clientId;

    /**
     * OAuth2: OPTIONAL
     *
     * @var RedirectUri
     */
    protected $redirectUri;

    /**
     * OAuth2: OPTIONAL
     *
     * @var Scope
     */
    protected $scope;

    /**
     * OAuth2: RECOMMENDED
     *
     * @var State
     */
    protected $state;

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
     * @param \MostSignificantBit\OAuth2\Client\Parameter\RedirectUri $redirectUri
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }

    /**
     * @return \MostSignificantBit\OAuth2\Client\Parameter\RedirectUri
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * @param \MostSignificantBit\OAuth2\Client\Parameter\Scope $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
    }

    /**
     * @return \MostSignificantBit\OAuth2\Client\Parameter\Scope
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @param \MostSignificantBit\OAuth2\Client\Parameter\State $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return \MostSignificantBit\OAuth2\Client\Parameter\State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return array
     */
    public function getQueryParameters()
    {
        $clientId = $this->getClientId();
        Assertion::notNull($clientId, 'clientId is required');

        $params = array(
            'response_type' => $this->getResponseType()->getValue(),
            'client_id'     => $clientId,
        );

        if ($this->getRedirectUri() !== null) {
            $params['redirect_uri'] = $this->getRedirectUri()->getValue();
        }

        if ($this->getScope() !== null) {
            $params['scope'] = $this->getScope()->getScopeParameter();
        }

        if ($this->getState() !== null) {
            $params['state'] = $this->getState();
        }

        return $params;
    }
}
