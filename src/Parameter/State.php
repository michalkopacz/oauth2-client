<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Parameter;

class State extends AbstractSingleParameter
{
    /**
     * @param string $state
     */
    public function __construct($state)
    {
        $this->setValue($state);
    }
}
