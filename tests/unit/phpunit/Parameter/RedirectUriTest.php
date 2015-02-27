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
     * @param $redirectUri
     * @expectedException \MostSignificantBit\OAuth2\Client\Exception\InvalidArgumentException
     * @expectedExceptionMessage Redirect uri must be absolute url without fragment component.
     */
    public function testInvalidRedirectUri($redirectUri)
    {
        new RedirectUri($redirectUri);
    }

    public function invalidRedirectUriProvider()
    {
        return array(
            array(''),
            array('example.org'),
            array('https://example.org/auth?foo=bar#baz'),
            array('file://example.org/auth'),
        );
    }
} 