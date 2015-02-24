<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 24.02.15
 * Time: 22:44
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
    public static function PUBLIC_TYPE() {
        return new ClientType(self::PUBLIC_TYPE);
    }

    /**
     * @return ClientType
     */
    public static function CONFIDENTIAL_TYPE() {
        return new ClientType(self::CONFIDENTIAL_TYPE);
    }
} 