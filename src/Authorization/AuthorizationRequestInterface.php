<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Authorization;

use MostSignificantBit\OAuth2\Client\Parameter\RedirectUri;
use MostSignificantBit\OAuth2\Client\Parameter\ResponseType;
use MostSignificantBit\OAuth2\Client\Parameter\Scope;
use MostSignificantBit\OAuth2\Client\Parameter\State;

interface AuthorizationRequestInterface
{
    /**
     * @return ResponseType
     */
    public function getResponseType();

    /**
     * ClientId is required, but we set it in \MostSignificantBit\OAuth2\Client\Client from config;
     *
     * @param string $clientId
     */
    public function setClientId($clientId);

    /**
     * @return string
     */
    public function getClientId();

    /**
     * @param RedirectUri $redirectUri
     */
    public function setRedirectUri(RedirectUri $redirectUri);

    /**
     * @return RedirectUri
     */
    public function getRedirectUri();

    /**
     * @param Scope $scope
     */
    public function setScope(Scope $scope);

    /**
     * @return Scope
     */
    public function getScope();

    /**
     * @param State $state
     */
    public function setState(State $state);

    /**
     * @return State
     */
    public function getState();

    /**
     * @return array
     */
    public function getQueryParameters();
}
