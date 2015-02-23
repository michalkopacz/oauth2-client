<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 21.02.15
 * Time: 18:23
 */

namespace MostSignificantBit\OAuth2\Client\Grant;

interface AuthorizationRequestAwareGrantInterface extends GrantInterface
{
    /**
     * @param AuthorizationRequestInterface $request
     */
    public function setAuthorizationRequest($request);

    /**
     * @return AuthorizationRequestInterface
     */
    public function getAuthorizationRequest();
} 