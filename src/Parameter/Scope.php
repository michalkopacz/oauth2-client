<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Parameter;

use MostSignificantBit\OAuth2\Client\Assert\Assertion;

class Scope implements ValueInterface
{
    const DEFAULT_SCOPE_TOKENS_DELIMITER = ' ';

    const SCOPE_TOKEN_REGEXP = '/^[\x21\x23-\x5B\x5D-\x7E]+$/';

    /**
     * @var string
     */
    protected $delimiter;

    /**
     * @var array
     */
    protected $scopeTokens;

    /**
     * @param array $scopeTokens
     * @param string $delimiter Delimiter should be set as space, because scopeToken can not include space chars.
     *                          But some oauth2 providers, like github, use comma as scopeTokens delimiters,
     *                          although scopeToken can include comma char.
     */
    public function __construct(array $scopeTokens, $delimiter = self::DEFAULT_SCOPE_TOKENS_DELIMITER)
    {
        $this->validate($scopeTokens);

        $this->scopeTokens = $scopeTokens;
        $this->delimiter = $delimiter;
    }

    /**
     * @return array
     */
    public function getValue()
    {
        return $this->scopeTokens;
    }

    /**
     * @return string
     */
    public function getScopeParameter()
    {
        return implode($this->delimiter, $this->getValue());
    }

    public static function fromParameter($scopeParameter, $delimiter = self::DEFAULT_SCOPE_TOKENS_DELIMITER)
    {
        $scopeTokens = explode($delimiter, $scopeParameter);

        return new self($scopeTokens, $delimiter);
    }

    protected function validate(array $scopeTokens)
    {
        Assertion::allRegex($scopeTokens, self::SCOPE_TOKEN_REGEXP);
    }
}
