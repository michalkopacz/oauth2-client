<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 14.02.15
 * Time: 20:59
 */

namespace MostSignificantBit\OAuth2\Client\Http;

class Response
{
    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var array
     */
    protected $body;

    /**
     * @param int $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param array $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return array
     */
    public function getBody()
    {
        return $this->body;
    }
}
