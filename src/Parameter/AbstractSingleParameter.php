<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
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
