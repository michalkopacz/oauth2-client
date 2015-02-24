<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 24.02.15
 * Time: 22:47
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
    public static function HTTP_BASIC() {
        return new ClientType(self::HTTP_BASIC);
    }

    /**
     * @return AuthenticationType
     */
    public static function REQUEST_BODY() {
        return new ClientType(self::REQUEST_BODY);
    }
} 