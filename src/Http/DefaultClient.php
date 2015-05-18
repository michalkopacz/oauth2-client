<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Http;

use Curl\Curl;
use MostSignificantBit\OAuth2\Client\Exception\InvalidArgumentException;

class DefaultClient implements ClientInterface
{
    /**
     * @var Curl
     */
    protected $curlClient;

    /**
     * @param Curl $curlClient
     */
    public function __construct(Curl $curlClient)
    {
        $this->curlClient = $curlClient;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws InvalidArgumentException
     */
    public function sendRequest(RequestInterface $request)
    {
        foreach ($request->getHeaders() as $name => $value) {
            $this->curlClient->setHeader($name, $value);
        }

        switch ($request->getMethod()) {
            case RequestInterface::METHOD_POST:
                $this->curlClient->post($request->getUrl(), $request->getBody());
                break;
            default:
                throw new InvalidArgumentException('Unsupported http request method ' . $request->getMethod(), 0, null, null, null);
        }

        if ($this->curlClient->curl_error === true) {
            throw new HttpClientException($this->curlClient->curl_error_message);
        }

        $response = new Response((int)$this->curlClient->http_status_code, $this->curlClient->raw_response);

        return $response;
    }
}