<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
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
