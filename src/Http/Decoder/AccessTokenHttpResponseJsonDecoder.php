<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Http\Decoder;

use Ivory\HttpAdapter\Message\ResponseInterface;
use Zend\Json\Exception\RuntimeException;
use Zend\Json\Json;

class AccessTokenHttpResponseJsonDecoder implements AccessTokenHttpResponseDecoderInterface
{
    public function getMimeType()
    {
        return 'application/json';
    }

    /**
     * @param ResponseInterface $httpResponse
     * @return array
     * @throws RuntimeException
     */
    public function decode(ResponseInterface $httpResponse)
    {
        return Json::decode($httpResponse->getBody()->getContents(), Json::TYPE_ARRAY);
    }
} 