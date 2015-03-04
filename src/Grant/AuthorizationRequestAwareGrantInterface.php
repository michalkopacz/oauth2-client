<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Grant;

use MostSignificantBit\OAuth2\Client\Authorization\AuthorizationRequestInterface;

interface AuthorizationRequestAwareGrantInterface extends GrantInterface
{
    /**
     * @param AuthorizationRequestInterface $request
     */
    public function setAuthorizationRequest(AuthorizationRequestInterface $request);

    /**
     * @return AuthorizationRequestInterface
     */
    public function getAuthorizationRequest();
}
