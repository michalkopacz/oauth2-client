<?php

namespace MostSignificantBit\OAuth2\Client\Assert;

use Assert\Assertion as BaseAssertion;

class Assertion extends BaseAssertion
{
    protected static $exceptionClass = 'MostSignificantBit\OAuth2\Client\Exception\InvalidArgumentException';
}