<?php
namespace MostSignificantBit\OAuth2\Client\Parameter;

use MyCLabs\Enum\Enum;

class GrantType extends Enum
{
    const AUTHORIZATION_CODE = 'authorization_code';
    const PASSWORD = 'password';
    const REFRESH_TOKEN = 'refresh_token';
    const CLIENT_CREDENTIALS = 'client_credentials';

    /**
     * @return GrantType
     */
    public static function AUTHORIZATION_CODE()
    {
        return new GrantType(self::AUTHORIZATION_CODE);
    }

    /**
     * @return GrantType
     */
    public static function PASSWORD()
    {
        return new GrantType(self::PASSWORD);
    }

    /**
     * @return GrantType
     */
    public static function REFRESH_TOKEN()
    {
        return new GrantType(self::REFRESH_TOKEN);
    }

    /**
     * @return GrantType
     */
    public static function CLIENT_CREDENTIALS()
    {
        return new GrantType(self::CLIENT_CREDENTIALS);
    }
}
