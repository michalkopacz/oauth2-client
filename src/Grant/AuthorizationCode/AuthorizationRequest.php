<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Grant\AuthorizationCode;

use MostSignificantBit\OAuth2\Client\Authorization\AbstractAuthorizationRequest;
use MostSignificantBit\OAuth2\Client\Parameter\ResponseType;

class AuthorizationRequest extends AbstractAuthorizationRequest
{
    /**
     * @return ResponseType
     */
    public function getResponseType()
    {
        return ResponseType::CODE();
    }
}
