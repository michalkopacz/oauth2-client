<?php
/**
 * Created by PhpStorm.
 * User: Michał Kopacz
 * Date: 15.02.15
 * Time: 12:46
 */

namespace MostSignificantBit\OAuth2\Client\GrantType;

class AuthorizationCodeGrant implements GrantTypeInterface
{
    const GRANT_TYPE = 'authorization_code';

    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $redirectUri;

    /**
     * @return string
     */
    public function getGrantType()
    {
        return self::GRANT_TYPE;
    }

    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $redirectUri
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }

    /**
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $params = array(
            'grant_type' => $this->getGrantType(),
            'code' => $this->getCode(),
        );

        if ($this->getRedirectUri() !== null) {
            $params['redirect_uri'] = $this->getRedirectUri();
        }

        return $params;
    }
}