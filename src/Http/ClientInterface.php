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
     * array(
     *   'authentication_type' =>
     *   'client_type' =>
     * )
     * @return Response
     */
    public function postAccessToken($url, array $params, array $options);
}
