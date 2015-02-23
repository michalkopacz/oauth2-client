<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 22.02.15
 * Time: 16:01
 */

namespace MostSignificantBit\OAuth2\Client\Parameter;


class ExpiresIn extends AbstractSingleParameter
{
    /**
     * @param int $expiresIn
     */
    public function __construct($expiresIn)
    {
        $this->setValue($expiresIn);
    }

    public function isValid($value)
    {
        return is_numeric($value) && $value >= 0;
    }
}
