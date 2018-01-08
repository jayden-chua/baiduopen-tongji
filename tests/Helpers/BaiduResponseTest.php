<?php

namespace BaiduOpen\Tests\Tongji\Helpers;

use BaiduOpen\Tongji\Helpers\BaiduResponse;
use ReflectionClass;
use ReflectionProperty;
use PHPUnit\Framework\TestCase;

class BaiduResponseTest extends TestCase
{
    /**
     * @var ReflectionClass
     */
    private $reflector;

    /**
     * @var ReflectionProperty
     */
    private $paramApiStatus;

    /**
     * @var ReflectionProperty
     */
    private $paramApiData;

    /**
     * @var ReflectionProperty
     */
    private $paramApiMessage;

    /**
     * @var ReflectionProperty
     */
    private $paramData;

    /**
     * @var BaiduResponse
     */
    private $response;

    public function setUp()
    {
        $this->reflector = new ReflectionClass(BaiduResponse::class);
        $this->paramApiStatus = $this->reflector->getProperty('apiStatus');
        $this->paramApiStatus->setAccessible(true);

        $this->paramApiData = $this->reflector->getProperty('apiData');
        $this->paramApiData->setAccessible(true);

        $this->paramApiMessage = $this->reflector->getProperty('apiMessage');
        $this->paramApiMessage->setAccessible(true);

        $this->paramData = $this->reflector->getProperty('data');
        $this->paramData->setAccessible(true);

        $this->response = new BaiduResponse();
    }

    public function testSetApiStatus_ShouldSetApiStatus()
    {
        $this->response->setApiStatus('Success');

        $actualApiStatus = $this->paramApiStatus->getValue($this->response);
        $this->assertEquals('Success', $actualApiStatus);
    }

    public function testIsSuccess_ShouldReturnTrue_WhenStatusSuccess()
    {
        $this->response->setApiStatus('Success');
        $this->assertTrue($this->response->isSuccess());
    }

    public function testIsSuccess_ShouldReturnFalse_WhenStatusOtherwise()
    {
        $this->response->setApiStatus('wrong');
        $this->assertFalse($this->response->isSuccess());
    }

    public function testGetApiStatus_ShouldGetApiStatus()
    {
        $actualApiStatus = $this->response->getApiStatus();

        $expectedApiStatus = $this->paramApiStatus->getValue($this->response);
        $this->assertEquals($expectedApiStatus, $actualApiStatus);
    }

    public function testSetApiData_ShouldSetApiData()
    {
        $this->response->setApiData(['apiData']);

        $actualApiData = $this->paramApiData->getValue($this->response);
        $this->assertEquals(['apiData'], $actualApiData);
    }

    public function testGetApiData_ShouldGetApiData()
    {
        $actualApiData = $this->response->getApiData();

        $expectedApiData = $this->paramApiData->getValue($this->response);
        $this->assertEquals($expectedApiData, $actualApiData);
    }

    public function testSetApiMessage_ShouldSetApiMessage()
    {
        $this->response->setApiMessage('apiMessage');

        $actualApiMessage = $this->paramApiMessage->getValue($this->response);
        $this->assertEquals('apiMessage', $actualApiMessage);
    }

    public function testGetApiMessage_ShouldGetApiMessage()
    {
        $actualApiMessage = $this->response->getApiMessage();

        $expectedApiMessage = $this->paramApiMessage->getValue($this->response);
        $this->assertEquals($expectedApiMessage, $actualApiMessage);
    }

    public function testSetData_ShouldSetData()
    {
        $this->response->setData(['data']);

        $actualData = $this->paramData->getValue($this->response);
        $this->assertEquals(['data'], $actualData);
    }

    public function testGetData_ShouldGetData()
    {
        $actualData = $this->response->getData();

        $expectedData = $this->paramData->getValue($this->response);
        $this->assertEquals($expectedData, $actualData);
    }

    public function testReset_ShouldResetAllProperties()
    {
        $this->response->setApiStatus('Success');
        $this->response->setApiMessage('apiMessage');
        $this->response->setApiData(['apiData']);
        $this->response->setData(['data']);

        $this->response->reset();

        $actualApiStatus = $this->paramApiStatus->getValue($this->response);
        $actualApiMessage = $this->paramApiMessage->getValue($this->response);
        $actualData = $this->paramData->getValue($this->response);
        $actualApiData = $this->paramApiData->getValue($this->response);

        $this->assertEquals('', $actualApiStatus);
        $this->assertEquals('', $actualApiMessage);
        $this->assertEquals([], $actualData);
        $this->assertEquals([], $actualApiData);
    }
}
