<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 22.02.15
 * Time: 14:19
 */

namespace MostSignificantBit\OAuth2\Client\Parameter;

use MostSignificantBit\OAuth2\Client\Assert\Assertion;

class AbstractSingleParameter implements ValueInterface
{
    protected $validationMessage = 'Value is not valid.';

    protected $value;

    protected function isValid($value)
    {
        return true;
    }

    protected function setValue($value)
    {
        Assertion::true($this->isValid($value), $this->validationMessage);

        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}
