<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2015 Michał Kopacz.
 * @author Michał Kopacz <michalkopacz.mk@gmail.com>
 */

namespace MostSignificantBit\OAuth2\Client\Tests\Unit;
use Ivory\HttpAdapter\Message\Request;
use Ivory\HttpAdapter\Message\Stream\StringStream;
use MostSignificantBit\OAuth2\Client\AccessToken\SuccessfulResponse;
use MostSignificantBit\OAuth2\Client\Config\AuthenticationType;
use MostSignificantBit\OAuth2\Client\Config\ClientType;
use MostSignificantBit\OAuth2\Client\DefaultAccessTokenObtainTemplate;
use MostSignificantBit\OAuth2\Client\Exception\InvalidArgumentException;
use MostSignificantBit\OAuth2\Client\Exception\TokenException;
use MostSignificantBit\OAuth2\Client\Parameter\AccessToken;
use MostSignificantBit\OAuth2\Client\Parameter\ExpiresIn;
use MostSignificantBit\OAuth2\Client\Parameter\RefreshToken;
use MostSignificantBit\OAuth2\Client\Parameter\Scope;
use MostSignificantBit\OAuth2\Client\Parameter\TokenType;

/**
 * @group unit
 */
class DefaultAccessTokenObtainTemplateTest extends \PHPUnit_Framework_TestCase
{
    public function testConvertAccessTokenRequestToHttpRequestWithHttpBasicAuthorization()
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

    public function testConvertAccessTokenRequestToHttpRequestWithRequestBodyAuthorizationAndConfidentialClientType()
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
            ->willReturn(AuthenticationType::REQUEST_BODY);

        $configMock->expects($this->once())
            ->method('getClientId')
            ->willReturn('s6BhdRkqt3');

        $configMock->expects($this->once())
            ->method('getClientSecret')
            ->willReturn('7Fjfp0ZBr1KtDRbnfVdmIw');

        $configMock->expects($this->once())
            ->method('getClientType')
            ->willReturn(ClientType::CONFIDENTIAL_TYPE);

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
            ),
            new StringStream('grant_type=password&username=johndoe&password=A3ddj3w&client_id=s6BhdRkqt3&client_secret=7Fjfp0ZBr1KtDRbnfVdmIw')
        );

        $this->assertEquals($expectedHttpRequest, $httpRequest);
    }

    public function testConvertAccessTokenRequestToHttpRequestWithRequestBodyAuthorizationAndPublicClientType()
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
            ->willReturn(AuthenticationType::REQUEST_BODY);

        $configMock->expects($this->once())
            ->method('getClientId')
            ->willReturn('s6BhdRkqt3');

        $configMock->expects($this->never())
            ->method('getClientSecret');

        $configMock->expects($this->once())
            ->method('getClientType')
            ->willReturn(ClientType::PUBLIC_TYPE);

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
            ),
            new StringStream('grant_type=password&username=johndoe&password=A3ddj3w&client_id=s6BhdRkqt3')
        );

        $this->assertEquals($expectedHttpRequest, $httpRequest);
    }

    public function testSendHttpRequest()
    {
        $httpClientMock = $this->getHttpClientMock();
        $configMock = $this->getConfigMock();
        $decoderMock = $this->getResponseJsonDecoderMock();

        $accessTokenObtainTemplate = new DefaultAccessTokenObtainTemplate($httpClientMock, $configMock, $decoderMock);

        $httpResponseMock = $this->getMockBuilder('\Ivory\HttpAdapter\Message\ResponseInterface')
            ->getMockForAbstractClass();

        $httpClientMock->expects($this->once())
            ->method('sendRequest')
            ->willReturn($httpResponseMock);

        $httpRequestMock = $this->getMockBuilder('\Ivory\HttpAdapter\Message\RequestInterface')
            ->setMethods(array('sendRequest'))
            ->getMockForAbstractClass();

        $httpResponse = $accessTokenObtainTemplate->sendHttpRequest($httpRequestMock);

        $this->assertSame($httpResponseMock, $httpResponse);
    }

    /**
     * @dataProvider responseStatusProvider
     */
    public function testIsSuccessfulResponse($statusCode, $isSuccessful)
    {
        $httpClientMock = $this->getHttpClientMock();
        $configMock = $this->getConfigMock();
        $decoderMock = $this->getResponseJsonDecoderMock();

        $accessTokenObtainTemplate = new DefaultAccessTokenObtainTemplate($httpClientMock, $configMock, $decoderMock);

        $httpResponseMock = $this->getMockBuilder('\Ivory\HttpAdapter\Message\ResponseInterface')
            ->setMethods(array('getStatusCode'))
            ->getMockForAbstractClass();

        $httpResponseMock->expects($this->once())
            ->method('getStatusCode')
            ->willReturn($statusCode);

        $this->assertSame($isSuccessful, $accessTokenObtainTemplate->isSuccessfulResponse($httpResponseMock));
    }

    public function testConvertHttpResponseToAccessTokenSuccessfulResponse()
    {
        $httpClientMock = $this->getHttpClientMock();
        $configMock = $this->getConfigMock();
        $decoderMock = $this->getResponseJsonDecoderMock();

        $accessTokenObtainTemplate = new DefaultAccessTokenObtainTemplate($httpClientMock, $configMock, $decoderMock);

        $httpResponseMock = $this->getMockBuilder('\Ivory\HttpAdapter\Message\ResponseInterface')
            ->getMockForAbstractClass();

        $decoderMock->expects($this->once())
            ->method('decode')
            ->with($httpResponseMock)
            ->willReturn(array(
                'access_token' => '2YotnFZFEjr1zCsicMWpAA',
                'token_type' => 'Bearer',
                'expires_in' => 3600,
                'refresh_token' => 'tGzv3JOkF0XG5Qx2TlKWIA',
                'scope' => 'example1 example2',
                'not_specified' => 'foo',
            ));

        $expectedAccessTokenSuccessFullResponse = new SuccessfulResponse(new AccessToken('2YotnFZFEjr1zCsicMWpAA'), new TokenType('Bearer'));
        $expectedAccessTokenSuccessFullResponse->setRefreshToken(new RefreshToken('tGzv3JOkF0XG5Qx2TlKWIA'));
        $expectedAccessTokenSuccessFullResponse->setExpiresIn(new ExpiresIn(3600));
        $expectedAccessTokenSuccessFullResponse->setScope(new Scope(array('example1', 'example2')));

        $accessTokenSuccessFullResponse = $accessTokenObtainTemplate->convertHttpResponseToAccessTokenSuccessfulResponse($httpResponseMock);

        $this->assertEquals($expectedAccessTokenSuccessFullResponse, $accessTokenSuccessFullResponse);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Access token param in body is required.
     */
    public function testConvertHttpResponseToAccessTokenSuccessfulResponseWithoutRequiredFields()
    {
        $httpClientMock = $this->getHttpClientMock();
        $configMock = $this->getConfigMock();
        $decoderMock = $this->getResponseJsonDecoderMock();

        $accessTokenObtainTemplate = new DefaultAccessTokenObtainTemplate($httpClientMock, $configMock, $decoderMock);

        $httpResponseMock = $this->getMockBuilder('\Ivory\HttpAdapter\Message\ResponseInterface')
            ->getMockForAbstractClass();

        $decoderMock->expects($this->once())
            ->method('decode')
            ->with($httpResponseMock)
            ->willReturn(array(
                'expires_in' => 3600,
                'refresh_token' => 'tGzv3JOkF0XG5Qx2TlKWIA',
                'scope' => 'example1 example2',
            ));

        $accessTokenObtainTemplate->convertHttpResponseToAccessTokenSuccessfulResponse($httpResponseMock);
    }

    public function testThrowTokenException()
    {
        $httpClientMock = $this->getHttpClientMock();
        $configMock = $this->getConfigMock();
        $decoderMock = $this->getResponseJsonDecoderMock();

        $accessTokenObtainTemplate = new DefaultAccessTokenObtainTemplate($httpClientMock, $configMock, $decoderMock);

        $httpResponseMock = $this->getMockBuilder('\Ivory\HttpAdapter\Message\ResponseInterface')
            ->getMockForAbstractClass();

        $decoderMock->expects($this->once())
            ->method('decode')
            ->with($httpResponseMock)
            ->willReturn(array(
                'error' => 'invalid_request',
                'error_description' => 'Invalid request',
                'error_uri' => 'https://auth.example.com/oauth2/errors/invalid_request'
            ));

        try {
            $accessTokenObtainTemplate->throwTokenException($httpResponseMock);
        } catch (TokenException $exception) {
            $this->assertSame('Invalid request', $exception->getMessage());
            $this->assertSame(TokenException::INVALID_REQUEST_CODE, $exception->getCode());
            $this->assertSame('invalid_request', $exception->getError());
            $this->assertSame('https://auth.example.com/oauth2/errors/invalid_request', $exception->getErrorUri());
            $this->assertSame('Invalid request', $exception->getErrorDescription());
        }
    }

    public function responseStatusProvider()
    {
        return array(
            array(200, true),
            array(400, false),
            array(404, false),
            array(500, false),
            array('200', false),
            array(null, false),
        );
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
            ->setMethods(array('getTokenEndpointUri', 'getClientAuthenticationType', 'getClientId', 'getClientSecret', 'getClientType'))
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