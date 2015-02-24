<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 22.02.15
 * Time: 14:19
 */

namespace MostSignificantBit\OAuth2\Client\Parameter;

use MostSignificantBit\OAuth2\Client\Assert\Assertion;

class AbstractSingleParameter
{
    protected $value;

    protected function isValid($value)
    {
        return true;
    }

    protected function setValue($value)
    {
        Assertion::true($this->isValid($value), 'Value is not valid');

        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}
