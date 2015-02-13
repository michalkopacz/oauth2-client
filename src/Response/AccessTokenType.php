<?php
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