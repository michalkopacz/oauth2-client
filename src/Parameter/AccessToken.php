<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 22.02.15
 * Time: 16:01
 */

namespace MostSignificantBit\OAuth2\Client\Parameter;

class AccessToken extends AbstractSingleParameter
{
    /**
     * @param string $accessToken
     */
    public function __construct($accessToken)
    {
        $this->setValue($accessToken);
    }
}
