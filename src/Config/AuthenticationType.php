<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Config;

use MyCLabs\Enum\Enum;

class AuthenticationType extends Enum
{
    const HTTP_BASIC = 'http_basic';
    const REQUEST_BODY = 'request_body';

    /**
     * @return AuthenticationType
     */
    public static function HTTP_BASIC()
    {
        return new ClientType(self::HTTP_BASIC);
    }

    /**
     * @return AuthenticationType
     */
    public static function REQUEST_BODY()
    {
        return new ClientType(self::REQUEST_BODY);
    }
}
