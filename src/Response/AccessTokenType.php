<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 13.02.15
 * Time: 21:45
 */

namespace MostSignificantBit\OAuth2\Client\Response;

use MyCLabs\Enum\Enum;

class AccessTokenType extends Enum
{
    const BEARER = 'Bearer';

    /**
     * @return AccessTokenType
     */
    public static function BEARER() {
        return new AccessTokenType(self::BEARER);
    }
} 