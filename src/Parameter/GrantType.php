<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Parameter;

use MyCLabs\Enum\Enum;

class GrantType extends Enum implements ValueInterface
{
    const AUTHORIZATION_CODE = 'authorization_code';
    const PASSWORD = 'password';
    const REFRESH_TOKEN = 'refresh_token';
    const CLIENT_CREDENTIALS = 'client_credentials';

    /**
     * @return GrantType
     */
    //@codingStandardsIgnoreStart
    public static function AUTHORIZATION_CODE()
    {
    // @codingStandardsIgnoreEnd

        return new GrantType(self::AUTHORIZATION_CODE);
    }

    /**
     * @return GrantType
     */
    //@codingStandardsIgnoreStart
    public static function PASSWORD()
    {
    // @codingStandardsIgnoreEnd

        return new GrantType(self::PASSWORD);
    }

    /**
     * @return GrantType
     */
    //@codingStandardsIgnoreStart
    public static function REFRESH_TOKEN()
    {
    // @codingStandardsIgnoreEnd

        return new GrantType(self::REFRESH_TOKEN);
    }

    /**
     * @return GrantType
     */
    //@codingStandardsIgnoreStart
    public static function CLIENT_CREDENTIALS()
    {
    // @codingStandardsIgnoreEnd

        return new GrantType(self::CLIENT_CREDENTIALS);
    }
}
