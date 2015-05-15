<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Http;

interface RequestInterface
{
    const METHOD_POST = "POST";

    public function setBody($body);
    /**
     * @return string
     */
    public function getBody();

    /**
     * @param string $name
     * @param string $value
     */
    public function addHeader($name, $value);

    /**
     * @return array
     */
    public function getHeaders();

    /**
     * @return string
     */
    public function getMethod();

    /**
     * @return string
     */
    public function getUrl();
} 