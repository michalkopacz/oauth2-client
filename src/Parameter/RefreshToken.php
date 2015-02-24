<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 22.02.15
 * Time: 16:01
 */

namespace MostSignificantBit\OAuth2\Client\Parameter;

class RefreshToken extends AbstractSingleParameter
{
    /**
     * @param string $refreshToken
     */
    public function __construct($refreshToken)
    {
        $this->setValue($refreshToken);
    }
}
