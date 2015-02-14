<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 13.02.15
 * Time: 23:35
 */

namespace MostSignificantBit\OAuth2\Client\Http;

use Coduo\PHPMatcher\Exception\Exception;
use GuzzleHttp\Client as GuzzleHttp;
use MostSignificantBit\OAuth2\Client\Config\Config;

class Guzzle5Adapter implements ClientInterface
{
    /**
     * @var GuzzleHttp
     */
    protected $client;

    public function __construct(GuzzleHttp $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $url
     * @param array $params
     * @param array $options
     * @return Response
     * @throws \Exception
     */
    public function postAccessToken($url, array $params, array $options)
    {
        $requestOptions = array(
            'body' => $params['body'],
        );

        switch ($options['authentication_type']) {
            case Config::CLIENT_REQUEST_BODY_AUTHENTICATION_TYPE:
                $requestOptions['body'] = array_merge($requestOptions['body'], $params['credentials']);
                break;
            case Config::CLIENT_HTTP_BASIC_AUTHENTICATION_TYPE:
                $requestOptions['auth'] = array(
                    $params['credentials']['client_id'],
                    $params['credentials']['client_secret'],
                );
                break;
            default:
                throw new \Exception('Unrecognized client authentication type');
        }

        $response = $this->client->post($url, $requestOptions);

        $oauth2Response = new Response();
        $oauth2Response->setStatusCode($response->getStatusCode());
        $oauth2Response->setBody($response->json());

        return $oauth2Response;
    }
}