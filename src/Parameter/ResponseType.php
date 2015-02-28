<?php
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
