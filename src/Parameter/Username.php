<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 23.02.15
 * Time: 12:59
 */

namespace MostSignificantBit\OAuth2\Client\Parameter;

class Username extends AbstractSingleParameter
{
    /**
     * @param string $username
     */
    public function __construct($username)
    {
        $this->setValue($username);
    }
}
