<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 22.02.15
 * Time: 14:12
 */

namespace MostSignificantBit\OAuth2\Client\Parameter;

class RedirectUri extends AbstractSingleParameter
{
    /**
     * @param string $redirectUri
     */
    public function __construct($redirectUri)
    {
        $this->setValue($redirectUri);
    }
}
