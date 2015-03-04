<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
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
