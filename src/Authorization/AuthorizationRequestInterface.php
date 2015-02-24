<?php
namespace MostSignificantBit\OAuth2\Client\Authorization;

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
     * @param \MostSignificantBit\OAuth2\Client\Parameter\RedirectUri $redirectUri
     */
    public function setRedirectUri($redirectUri);

    /**
     * @return \MostSignificantBit\OAuth2\Client\Parameter\RedirectUri
     */
    public function getRedirectUri();

    /**
     * @param \MostSignificantBit\OAuth2\Client\Parameter\Scope $scope
     */
    public function setScope($scope);

    /**
     * @return \MostSignificantBit\OAuth2\Client\Parameter\Scope
     */
    public function getScope();

    /**
     * @param \MostSignificantBit\OAuth2\Client\Parameter\State $state
     */
    public function setState($state);

    /**
     * @return \MostSignificantBit\OAuth2\Client\Parameter\State
     */
    public function getState();

    /**
     * @return array
     */
    public function getQueryParameters();
} 