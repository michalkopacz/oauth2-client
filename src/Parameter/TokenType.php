<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Parameter;

use MyCLabs\Enum\Enum;

class TokenType extends Enum implements ValueInterface
{
    const BEARER = 'Bearer';

    /**
     * @return TokenType
     */
    public static function BEARER()
    {
        return new TokenType(self::BEARER);
    }
}
