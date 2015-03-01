<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client;

use Ivory\HttpAdapter\Message\ResponseInterface;

class AccessTokenHttpResponseJsonDecoder implements AccessTokenHttpResponseDecoderInterface
{
    public function getMimeType()
    {
        return 'application/json';
    }

    public function decode(ResponseInterface $httpResponse)
    {
        return json_decode($httpResponse->getBody()->getContents(), true);
    }
} 