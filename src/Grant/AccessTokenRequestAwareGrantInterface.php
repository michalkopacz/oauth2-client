<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 21.02.15
 * Time: 18:22
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
