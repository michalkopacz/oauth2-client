<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Grant;

use MostSignificantBit\OAuth2\Client\AccessToken\RequestInterface as AccessTokenRequestInterface;

interface AccessTokenRequestAwareGrantInterface extends GrantInterface
{
    /**
     * @param AccessTokenRequestInterface $request
     */
    public function setAccessTokenRequest(AccessTokenRequestInterface $request);

    /**
     * @return AccessTokenRequestInterface
     */
    public function getAccessTokenRequest();
}
