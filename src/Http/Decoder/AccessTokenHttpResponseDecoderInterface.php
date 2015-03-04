<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Http\Decoder;

use Ivory\HttpAdapter\Message\ResponseInterface;

interface AccessTokenHttpResponseDecoderInterface
{
    /**
     * @return string
     */
    public function getMimeType();

    /**
     * @param ResponseInterface $httpResponse
     * @return array
     */
    public function decode(ResponseInterface $httpResponse);
}
