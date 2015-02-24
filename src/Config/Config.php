<?php
namespace MostSignificantBit\OAuth2\Client\Config;

use MostSignificantBit\OAuth2\Client\Assert\Assertion;
use MostSignificantBit\OAuth2\Client\Exception\InvalidArgumentException;
use Zend\Stdlib\ArrayUtils;

class Config
{
    const CLIENT_HTTP_BASIC_AUTHENTICATION_TYPE = 'http_basic';
    const CLIENT_REQUEST_BODY_AUTHENTICATION_TYPE = 'request_body';

    const CLIENT_PUBLIC_TYPE = 'public';
    const CLIENT_CONFIDENTIAL_TYPE = 'confidential';

    protected $config = array(
        'endpoint' => array(
            'token_endpoint_uri' => null,
            'authorization_endpoint_uri' => null,
        ),
        'client' => array(
            'type' => self::CLIENT_CONFIDENTIAL_TYPE,
            'credentials' => array(
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
     *          'type' => DEFAULT 'confidential'
     *          'credentials' => array (
     *              'client_id' => REQUIRED
     *              'client_secret' => REQUIRED if type is 'confidential'
     *          ),
     *          'authentication_type' => DEFAULT 'http_basic'
     *      ),
     * }
     */
    public function __construct(array $config)
    {
        //endpoint section
        Assertion::keyExists($config, 'endpoint', 'Endpoint section is required.');
        Assertion::keyExists($config['endpoint'], 'token_endpoint_uri', 'Token endpoint uri is required.');

        //client section
        Assertion::keyExists($config, 'client', 'Client section is required.');

        $clientType = isset($config['client']['type']) ? $config['client']['type'] : $this->config['client']['type'];
        $clientAuthenticationType = isset($config['client']['authentication_type']) ? $config['client']['authentication_type'] : $this->config['client']['authentication_type'];

        Assertion::inArray(
            $clientType,
            array(self::CLIENT_CONFIDENTIAL_TYPE, self::CLIENT_PUBLIC_TYPE),
            "Client type must be set to 'confidential' or 'public'."
        );

        Assertion::inArray(
            $clientAuthenticationType,
            array(self::CLIENT_HTTP_BASIC_AUTHENTICATION_TYPE, self::CLIENT_REQUEST_BODY_AUTHENTICATION_TYPE),
            "Client authentication type must be set to 'http_basic' or 'request_body'."
        );

        if ($clientType === self::CLIENT_PUBLIC_TYPE && $clientAuthenticationType === self::CLIENT_HTTP_BASIC_AUTHENTICATION_TYPE) {
            throw new InvalidArgumentException("HTTP basic authentication type is not allowed for public client.", 0, null, null);
        }

        Assertion::keyExists($config['client'], 'credentials', 'Client credentials section is required.');
        Assertion::keyExists($config['client']['credentials'], 'client_id', 'Client id is required.');

        if ($clientType === self::CLIENT_CONFIDENTIAL_TYPE) {
            Assertion::keyExists($config['client']['credentials'], 'client_secret', 'Client secret is required for confidential client type.');
        }

        $this->config = ArrayUtils::merge($this->config, $config);
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
     * @return string
     */
    public function getClientType()
    {
        return $this->config['client']['type'];
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