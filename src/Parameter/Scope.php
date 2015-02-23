<?php
namespace MostSignificantBit\OAuth2\Client\Parameter;

class Scope
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
        $this->scopeTokens = $scopeTokens;
        $this->delimiter = $delimiter;
    }

    /**
     * @return array
     */
    public function getScopeTokens()
    {
        return $this->scopeTokens;
    }

    /**
     * @return string
     */
    public function getScopeParameter()
    {
        return implode($this->delimiter, $this->getScopeTokens());
    }

    public static function fromParameter($scopeParameter, $delimiter = self::DEFAULT_SCOPE_TOKENS_DELIMITER)
    {
        $scopeTokens = explode($delimiter, $scopeParameter);

        return new self($scopeTokens, $delimiter);
    }
} 