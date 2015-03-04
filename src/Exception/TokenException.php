<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Exception;

class TokenException extends \Exception implements OAuth2ClientExceptionInterface
{
    const INVALID_REQUEST_CODE = 1;
    const INVALID_CLIENT_CODE = 2;
    const INVALID_GRANT_CODE  = 3;
    const UNAUTHORIZED_CLIENT_CODE  = 4;
    const UNSUPPORTED_GRANT_TYPE_CODE  = 5;
    const INVALID_SCOPE_CODE = 6;

    /**
     * @var string
     */
    protected $error;

    /**
     * @var string
     */
    protected $errorDescription;

    /**
     * @var string
     */
    protected $errorUri;


    public function __construct($error, $errorDescription = null, $errorUri = null, $previous = null)
    {
        $this->error = $error;
        $this->errorDescription = $errorDescription;
        $this->errorUri = $errorUri;

        if ($errorDescription !== null) {
            $message = $errorDescription;
        } else {
            $message = ucfirst(str_replace('_', ' ', $error));
        }

        $code = $this->getCodeForError($error);

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return string
     */
    public function getErrorDescription()
    {
        return $this->errorDescription;
    }

    /**
     * @return string
     */
    public function getErrorUri()
    {
        return $this->errorUri;
    }

    protected function getCodeForError($error)
    {
        $codeConst = "self::" . strtoupper($error) . '_CODE';

        if (defined($codeConst)) {
            return constant($codeConst);
        }

        return 0;
    }
}
