<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Tests\Unit;
use Ivory\HttpAdapter\Message\Request;
use Ivory\HttpAdapter\Message\Stream\StringStream;
use MostSignificantBit\OAuth2\Client\Config\AuthenticationType;
use MostSignificantBit\OAuth2\Client\DefaultAccessTokenObtainTemplate;

/**
 * @group unit
 */
class DefaultAccessTokenObtainTemplateTest extends \PHPUnit_Framework_TestCase
{
    public function testConvertAccessTokenRequestToHttpRequest()
    {
        $httpClientMock = $this->getHttpClientMock();
        $configMock = $this->getConfigMock();
        $decoderMock = $this->getResponseJsonDecoderMock();

        $accessTokenObtainTemplate = new DefaultAccessTokenObtainTemplate($httpClientMock, $configMock, $decoderMock);

        $configMock->expects($this->once())
                   ->method('getTokenEndpointUri')
                   ->willReturn('https://auth.example.com/token');

        $accessTokenRequestMock = $this->getAccessTokenRequestMock();
        $accessTokenRequestMock
            ->expects($this->once())
            ->method('getBodyParameters')
            ->willReturn(array(
                'grant_type' => 'password',
                'username' => 'johndoe',
                'password' => 'A3ddj3w',
            ));

        $configMock->expects($this->once())
            ->method('getClientAuthenticationType')
            ->willReturn(AuthenticationType::HTTP_BASIC);

        $configMock->expects($this->once())
            ->method('getClientId')
            ->willReturn('s6BhdRkqt3');

        $configMock->expects($this->once())
            ->method('getClientSecret')
            ->willReturn('7Fjfp0ZBr1KtDRbnfVdmIw');


        $decoderMock->expects($this->once())
            ->method('getMimeType')
            ->willReturn('application/json');


        $httpRequest = $accessTokenObtainTemplate->convertAccessTokenRequestToHttpRequest($accessTokenRequestMock);

        $expectedHttpRequest = new Request(
            'https://auth.example.com/token',
            Request::METHOD_POST,
            Request::PROTOCOL_VERSION_1_1,
            array(
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json',
                'Authorization' => 'Basic czZCaGRSa3F0Mzo3RmpmcDBaQnIxS3REUmJuZlZkbUl3',
            ),
            new StringStream('grant_type=password&username=johndoe&password=A3ddj3w')
        );

        $this->assertEquals($expectedHttpRequest, $httpRequest);
    }

    protected function getHttpClientMock()
    {
        return $this->getMockBuilder('\Ivory\HttpAdapter\HttpAdapterInterface')
            ->setMethods(array('sendRequest'))
            ->getMockForAbstractClass();
    }

    protected function getConfigMock()
    {
        return $this->getMockBuilder('\MostSignificantBit\OAuth2\Client\Config\Config')
            ->setMethods(array('getTokenEndpointUri', 'getClientAuthenticationType', 'getClientId', 'getClientSecret'))
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function getResponseJsonDecoderMock()
    {
        return $this->getMockBuilder('\MostSignificantBit\OAuth2\Client\Http\Decoder\AccessTokenHttpResponseJsonDecoder')
            ->setMethods(array('getMimeType', 'decode'))
            ->getMock();
    }

    protected function getAccessTokenRequestMock()
    {
        return $this->getMockBuilder('\MostSignificantBit\OAuth2\Client\AccessToken\RequestInterface')
            ->setMethods(array('getBodyParameters'))
            ->getMockForAbstractClass();
    }
} 