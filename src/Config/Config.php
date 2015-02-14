<?php
namespace MostSignificantBit\OAuth2\Client\Config;

use Assert\Assertion;

class Config
{
    const CLIENT_HTTP_BASIC_AUTHENTICATION_TYPE = 'http_basic';
    const CLIENT_REQUEST_BODY_AUTHENTICATION_TYPE = 'request_body';

    protected $config = array(
        'client' => array(
            'authentication_type' => self::CLIENT_HTTP_BASIC_AUTHENTICATION_TYPE,
        ),
    );

    /**
     * @param array $config
     * array(
     *      'endpoint' => array(
     *          'token_endpoint_url' => REQUIRED
     *      ),
     *      'client' => array(
     *          'credentials' => array (
     *              'client_id' => REQUIRED
     *              'client_secret' => REQUIRED
     *          ),
     *          'authentication_type' => DEFAULT 'http_basic'
     *      ),
     * }
     */
    public function __construct(array $config)
    {
        Assertion::keyExists($config, 'endpoint', 'Endpoint section is required');
        Assertion::keyExists($config['endpoint'], 'token_endpoint_url', 'Token endpoint url is required');

        Assertion::keyExists($config, 'client',  'Client section is required');
        Assertion::keyExists($config['client'], 'credentials',  'Client credentials section is required');
        Assertion::keyExists($config['client']['credentials'], 'client_id',  'Client id is required');
        Assertion::keyExists($config['client']['credentials'], 'client_secret',  'Client secret is required');

        $this->config = array_merge($this->config, $config);
    }

    /**
     * @return string
     */
    public function getTokenEndpointUrl()
    {
        return $this->config['endpoint']['token_endpoint_url'];
    }

    /**
     * @return array
     */
    public function getClientCredentials()
    {
        return $this->config['client']['credentials'];
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->config['client']['credentials']['client_id'];
    }

    /**
     * @return string
     */
    public function getClientSecret()
    {
        return $this->config['client']['credentials']['client_secret'];
    }

    /**
     * @return string
     */
    public function getClientAuthenticationType()
    {
        return $this->config['client']['authentication_type'];
    }
} 