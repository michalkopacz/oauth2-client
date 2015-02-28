<?php
namespace MostSignificantBit\OAuth2\Client\Parameter;

use Assert\Assertion;

class Scope implements ValueInterface
{
    const DEFAULT_SCOPE_TOKENS_DELIMITER = ' ';

    /**
     * @var string
     */
    protected $delimiter;

    /**
     * @var
     */
    protected $scopeTokens;

    public function __construct(array $scopeTokens, $delimiter = self::DEFAULT_SCOPE_TOKENS_DELIMITER)
    {
        $this->isValid($scopeTokens);

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

    protected function isValid(array $scopeTokens)
    {
        foreach ($scopeTokens as $scopeToken) {
            Assertion::regex($scopeToken, '/^%[x21%x23-5B%x5D-7E]+$/');
        }
    }
}
