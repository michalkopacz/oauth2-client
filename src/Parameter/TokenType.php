<?php
namespace MostSignificantBit\OAuth2\Client\Parameter;

use MyCLabs\Enum\Enum;

class TokenType extends Enum
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
