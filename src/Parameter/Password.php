<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 23.02.15
 * Time: 12:59
 */

namespace MostSignificantBit\OAuth2\Client\Parameter;

class Password extends AbstractSingleParameter
{
    /**
     * @param string $password
     */
    public function __construct($password)
    {
        $this->setValue($password);
    }
}
