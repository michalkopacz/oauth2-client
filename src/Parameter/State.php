<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 24.02.15
 * Time: 21:05
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
