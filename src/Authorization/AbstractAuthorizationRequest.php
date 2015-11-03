<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

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
     * @param RedirectUri $redirectUri
     */
    public function setRedirectUri(RedirectUri $redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }

    /**
     * @return RedirectUri
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * @param Scope $scope
     */
    public function setScope(Scope $scope)
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
     * @param State $state
     */
    public function setState(State $state)
    {
        $this->state = $state;
    }

    /**
     * @return State
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
