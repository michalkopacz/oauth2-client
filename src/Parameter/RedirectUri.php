<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Parameter;

use Zend\Uri\Exception\InvalidArgumentException;
use Zend\Uri\Http;

class RedirectUri extends AbstractSingleParameter
{
    protected $validationMessage = 'Redirect uri must be absolute url without fragment component.';

    /**
     * @param string $redirectUri
     */
    public function __construct($redirectUri)
    {
        $this->setValue($redirectUri);
    }

    protected function isValid($value)
    {
        try {
            $uri = new Http($value);

            return $uri->isValid() && $uri->isAbsolute() && $uri->getFragment() === null;
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }
}
