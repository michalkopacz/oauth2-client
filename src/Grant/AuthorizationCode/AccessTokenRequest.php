<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Grant\AuthorizationCode;

use MostSignificantBit\OAuth2\Client\AccessToken\RequestInterface as AccessTokenRequestInterface;
use MostSignificantBit\OAuth2\Client\Parameter\Code;
use MostSignificantBit\OAuth2\Client\Parameter\GrantType;
use MostSignificantBit\OAuth2\Client\Parameter\RedirectUri;

class AccessTokenRequest implements AccessTokenRequestInterface
{
    /**
     * The authorization code received from the authorization server.
     *
     * OAuth2: REQUIRED
     *
     * @var Code
     */
    protected $code;

    /**
     * Parameter included in the  authorization request.
     *
     * OAuth2: REQUIRED, if the "redirect_uri" parameter was included in the authorization request.
     *
     * @var RedirectUri
     */
    protected $redirectUri;

    /**
     * @param Code $code
     */
    public function __construct(Code $code)
    {
        $this->setCode($code);
    }

    /**
     * @return GrantType
     */
    public function getGrantType()
    {
        return GrantType::AUTHORIZATION_CODE();
    }

    /**
     * @param Code $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return Code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param RedirectUri $redirectUri
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }

    /**
     * @return RedirectUri
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * @return array
     */
    public function getBodyParameters()
    {
        $parameters = array(
            'grant_type' => $this->getGrantType()->getValue(),
            'code' => $this->getCode()->getValue(),
        );

        if (isset($this->redirectUri)) {
            $parameters['redirect_uri'] = $this->getRedirectUri()->getValue();
        }

        return $parameters;
    }
}
