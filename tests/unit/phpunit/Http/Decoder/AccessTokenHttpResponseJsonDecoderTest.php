<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Tests\Unit\Http\Decoder;
use MostSignificantBit\OAuth2\Client\Http\Decoder\AccessTokenHttpResponseJsonDecoder;
use Zend\Json\Exception\RuntimeException;

/**
 * @group unit
 */
class AccessTokenHttpResponseJsonDecoderTest extends \PHPUnit_Framework_TestCase
{
    public function testDecodedDataIsArray()
    {
        $decoder = new AccessTokenHttpResponseJsonDecoder();

        $httpResponse = $this->getHttpResponseMock('{"access_token":"2YotnFZFEjr1zCsicMWpAA","token_type":"example"}');
        $body = $decoder->decode($httpResponse);

        $this->assertSame(array(
            "access_token" => "2YotnFZFEjr1zCsicMWpAA",
            "token_type" => "example",
        ), $body);
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage Decoding failed: Syntax error
     */
    public function testDecodedDataIsNotJson()
    {
        $decoder = new AccessTokenHttpResponseJsonDecoder();

        $httpResponse = $this->getHttpResponseMock('not json');
        $decoder->decode($httpResponse);
    }

    public function testGetMimeTypeIsApplicationJson()
    {
        $decoder = new AccessTokenHttpResponseJsonDecoder();

        $this->assertSame('application/json', $decoder->getMimeType());
    }

    protected  function getHttpResponseMock($content)
    {
        $httpResponse = $this->getMockBuilder('\Ivory\HttpAdapter\Message\ResponseInterface')
            ->setMethods(array('getBody'))
            ->getMockForAbstractClass();

        $streamable = $this->getMockBuilder('\Psr\Http\Message\StreamableInterface')
            ->setMethods(array('getContents'))
            ->getMockForAbstractClass();

        $streamable->expects($this->once())
            ->method('getContents')
            ->willReturn($content);

        $httpResponse->expects($this->once())
            ->method('getBody')
            ->willReturn($streamable);

        return $httpResponse;
    }
} 