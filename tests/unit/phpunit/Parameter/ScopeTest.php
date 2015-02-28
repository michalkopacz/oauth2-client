<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */
namespace MostSignificantBit\OAuth2\Client\Tests\Unit\Parameter;

use MostSignificantBit\OAuth2\Client\Parameter\Scope;

class ScopeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider invalidScopeProvider
     * @param $uri
     * @expectedException \MostSignificantBit\OAuth2\Client\Exception\InvalidArgumentException
     */
    public function testInvalidScope($scopeTokens)
    {
        new Scope($scopeTokens);
    }

    /**
     * @dataProvider validScopeProvider
     * @param $uri
     */
    public function testValidScope($scopeTokens)
    {
        $redirectUri = new Scope($scopeTokens);

        $this->assertSame($scopeTokens, $redirectUri->getValue());
    }

    public function testScopeParameterWithDefaultDelimiter()
    {
        $scope = new Scope(array('user_profile', 'email', 'photos'));

        $this->assertSame('user_profile email photos', $scope->getScopeParameter());
    }

    /**
     * @dataProvider scopeDelimiters
     *
     * @param $delimiter
     * @param $expectedParameter
     */
    public function testScopeParameterWithDelimiter($delimiter, $expectedParameter)
    {
        $scope = new Scope(array('user_profile', 'email', 'photos'), $delimiter);

        $this->assertSame($expectedParameter, $scope->getScopeParameter());
    }

    public function testCreateScopeFromParameter()
    {
        $scope = Scope::fromParameter('user_profile email photos');

        $this->assertEquals(new Scope(array('user_profile', 'email', 'photos')), $scope);
    }

    public function invalidScopeProvider()
    {
        return array(
            array(array('"scope')),
            array(array('scope\\')),
            array(array('объем')),
            array(array(' ')),
        );
    }

    public function validScopeProvider()
    {
        return array(
            array(array('!#[]~')),
            array(array('user_profile', 'email')),
        );
    }

    public function scopeDelimiters()
    {
        return array(
            array(' ', 'user_profile email photos'),
            array(',', 'user_profile,email,photos'),
            array(':', 'user_profile:email:photos'),
        );
    }
} 