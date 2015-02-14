<?php
namespace MostSignificantBit\OAuth2\Client\Http;


interface ClientInterface
{
    /**
     * @param string $url
     * @param array $params
     * array(
     *   'body' => array()
     *   'credentials' => array(
     *      'client_id' =>
     *      'client_secret' =>
     *   )
     * )
     * @param array $options
     * @return array
     */
    public function postAccessToken($url, array $params, array $options);
} 