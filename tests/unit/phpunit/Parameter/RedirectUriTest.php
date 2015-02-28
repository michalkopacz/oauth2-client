<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */
namespace MostSignificantBit\OAuth2\Client\Tests\Unit\Parameter;

use MostSignificantBit\OAuth2\Client\Parameter\RedirectUri;

class RedirectUriTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider invalidRedirectUriProvider
     * @param $uri
     * @expectedException \MostSignificantBit\OAuth2\Client\Exception\InvalidArgumentException
     * @expectedExceptionMessage Redirect uri must be absolute url without fragment component.
     */
    public function testInvalidRedirectUri($uri)
    {
        new RedirectUri($uri);
    }

    /**
     * @dataProvider validRedirectUriProvider
     * @param $uri
     */
    public function testValidRedirectUri($uri)
    {
        $redirectUri = new RedirectUri($uri);

        $this->assertSame($uri, $redirectUri->getValue());
    }

    public function invalidRedirectUriProvider()
    {
        return array(
            array(''),
            array('example.org'),
            array('https://example.org/auth?foo=bar#baz'),
            array('file://example.org/auth'),
            array('127.0.0.1:8080'),
        );
    }

    public function validRedirectUriProvider()
    {
        return array(
            array('http://127.0.0.1:8080/auth'),
            array('https://example.org/auth?foo=bar'),
        );
    }
} 