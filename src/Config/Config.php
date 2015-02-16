<?php
namespace MostSignificantBit\OAuth2\Client\Config;

use MostSignificantBit\OAuth2\Client\Assert\Assertion;

class Config
{
    const CLIENT_HTTP_BASIC_AUTHENTICATION_TYPE = 'http_basic';
    const CLIENT_REQUEST_BODY_AUTHENTICATION_TYPE = 'request_body';

    protected $config = array(
        'endpoint' => array(
           'token_endpoint_uri' => null,
           'authorization_endpoint_uri' => null,
        ),
        'client' => array(
           'credentials' => array (
               'client_id' => null,
               'client_secret' => null,
           ),
           'authentication_type' => self::CLIENT_HTTP_BASIC_AUTHENTICATION_TYPE,
        ),
    );

    /**
     * @param array $config
     * array(
     *      'endpoint' => array(
     *          'token_endpoint_uri' => REQUIRED,
     *          'authorization_endpoint_uri' => REQUIRED if we use authorization request
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
        Assertion::keyExists($config['endpoint'], 'token_endpoint_uri', 'Token endpoint uri is required');

        Assertion::keyExists($config, 'client',  'Client section is required');
        Assertion::keyExists($config['client'], 'credentials',  'Client credentials section is required');
        Assertion::keyExists($config['client']['credentials'], 'client_id',  'Client id is required');
        Assertion::keyExists($config['client']['credentials'], 'client_secret',  'Client secret is required');

        if (isset($config['client']['authentication_type'])) {
            Assertion::inArray($config['client']['authentication_type'], array(self::CLIENT_HTTP_BASIC_AUTHENTICATION_TYPE, self::CLIENT_REQUEST_BODY_AUTHENTICATION_TYPE));
        }

        $this->config = $this->merge($this->config, $config);
    }

    /**
     * Copy form Zf2 stdlib, because we want to have compatiblity with php 5.3.0
     * @link https://github.com/zendframework/zf2/blob/master/library/Zend/Stdlib/ArrayUtils.php
     */
    public function merge(array $a, array $b)
    {
        foreach ($b as $key => $value) {
            if (isset($a[$key]) || array_key_exists($key, $a)) {
                if (is_array($value) && is_array($a[$key])) {
                    $a[$key] = $this->merge($a[$key], $value);
                } else {
                    $a[$key] = $value;
                }
            } else {
                $a[$key] = $value;
            }
        }

        return $a;
    }

    /**
     * @return string
     */
    public function getTokenEndpointUri()
    {
        return $this->config['endpoint']['token_endpoint_uri'];
    }

    /**
     * @return string|null
     */
    public function getAuthorizationEndpointUri()
    {
        return $this->config['endpoint']['authorization_endpoint_uri'];
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