<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Parameter;

use MyCLabs\Enum\Enum;

class ResponseType extends Enum implements ValueInterface
{
    const CODE = 'code';
    const TOKEN = 'token';

    /**
     * @return ResponseType
     */
    public static function CODE()
    {
        return new ResponseType(self::CODE);
    }

    /**
     * @return ResponseType
     */
    public static function TOKEN()
    {
        return new ResponseType(self::TOKEN);
    }
}
