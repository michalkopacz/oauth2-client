<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 22.02.15
 * Time: 14:23
 */

namespace MostSignificantBit\OAuth2\Client\Parameter;


class Code extends AbstractSingleParameter
{
    /**
     * @param string $code
     */
    public function __construct($code)
    {
        $this->setValue($code);
    }
} 