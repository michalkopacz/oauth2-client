<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Config;

use MostSignificantBit\OAuth2\Client\Assert\Assertion;
use MostSignificantBit\OAuth2\Client\Exception\InvalidArgumentException;
use MostSignificantBit\OAuth2\Client\Parameter\Scope;
use Zend\Stdlib\ArrayUtils;

class Config
{
    protected $config = array(
        'endpoint' => array(
            'token_endpoint_uri' => null,
            'authorization_endpoint_uri' => null,
        ),
        'client' => array(
            'type' => ClientType::CONFIDENTIAL_TYPE,
            'credentials' => array(
                'client_id' => null,
                'client_secret' => null,
            ),
            'authentication_type' => AuthenticationType::HTTP_BASIC,
        ),
        'parameters' => array(
               'scope' => array(
                   'delimiter' => Scope::DEFAULT_SCOPE_TOKENS_DELIMITER,
               ),
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
     *      'parameters' => array(
     *          'scope' => array(
     *              'delimiter' =>
     *          ),
     *      ),
     * }
     */
    public function __construct(array $config)
    {
        //endpoint section
        //TODO: move require check to client obtainAccessToken method
        Assertion::keyExists($config, 'endpoint', 'Endpoint section is required.');
        Assertion::keyExists($config['endpoint'], 'token_endpoint_uri', 'Token endpoint uri is required.');

        //client section
        Assertion::keyExists($config, 'client', 'Client section is required.');

        $clientType = isset($config['client']['type']) ? $config['client']['type'] : $this->config['client']['type'];
        $clientAuthenticationType = isset($config['client']['authentication_type']) ? $config['client']['authentication_type'] : $this->config['client']['authentication_type'];

        Assertion::inArray(
            $clientType,
            array(ClientType::CONFIDENTIAL_TYPE, ClientType::PUBLIC_TYPE),
            "Client type must be set to 'confidential' or 'public'."
        );

        Assertion::inArray(
            $clientAuthenticationType,
            array(AuthenticationType::HTTP_BASIC, AuthenticationType::REQUEST_BODY),
            "Client authentication type must be set to 'http_basic' or 'request_body'."
        );

        if ($clientType === ClientType::PUBLIC_TYPE && $clientAuthenticationType === AuthenticationType::REQUEST_BODY) {
            throw new InvalidArgumentException("HTTP basic authentication type is not allowed for public client.", 0, null, null);
        }

        Assertion::keyExists($config['client'], 'credentials', 'Client credentials section is required.');
        Assertion::keyExists($config['client']['credentials'], 'client_id', 'Client id is required.');

        if ($clientType === ClientType::CONFIDENTIAL_TYPE) {
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
     * @return string
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
