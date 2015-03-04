<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Config;

use MyCLabs\Enum\Enum;

class ClientType extends Enum
{
    const PUBLIC_TYPE = 'public';
    const CONFIDENTIAL_TYPE = 'confidential';

    /**
     * @return ClientType
     */
    public static function PUBLIC_TYPE()
    {
        return new ClientType(self::PUBLIC_TYPE);
    }

    /**
     * @return ClientType
     */
    public static function CONFIDENTIAL_TYPE()
    {
        return new ClientType(self::CONFIDENTIAL_TYPE);
    }
}
