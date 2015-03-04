<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\AccessToken;

use MostSignificantBit\OAuth2\Client\Parameter\GrantType;

interface RequestInterface
{
    /**
     * @return array
     */
    public function getBodyParameters();

    /**
     * @return GrantType
     */
    public function getGrantType();
}
