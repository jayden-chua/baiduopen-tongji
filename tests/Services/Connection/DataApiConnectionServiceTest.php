<?php

namespace BaiduOpen\Tests\Tongji\Services\Connection;

use ReflectionClass;
use ReflectionProperty;
use BaiduOpen\Tongji\Services\Connection\DataApiConnectionService;
use PHPUnit\Framework\TestCase;

class DataApiConnectionServiceTest extends TestCase
{
    /**
     * @var ReflectionClass
     */
    private $reflector;

    /**
     * @var ReflectionProperty
     */
    private $paramUrl;

    /**
     * @var ReflectionProperty
     */
    private $paramHeaders;

    /**
     * @var ReflectionProperty
     */
    private $paramPostData;

    /**
     * @var ReflectionProperty
     */
    private $paramUcid;

    public function setUp()
    {
        $this->reflector = new ReflectionClass(DataApiConnectionService::class);
        $this->paramUrl = $this->reflector->getProperty('url');
        $this->paramUrl->setAccessible(true);

        $this->paramHeaders = $this->reflector->getProperty('headers');
        $this->paramHeaders->setAccessible(true);

        $this->paramUcid = $this->reflector->getProperty('ucid');
        $this->paramUcid->setAccessible(true);

        $this->paramPostData = $this->reflector->getProperty('postData');
        $this->paramPostData->setAccessible(true);
    }

    public function testSetUcid_ShouldSetUcid()
    {
        $expected = 'abc';

        $dataApiConnectionService = new DataApiConnectionService();
        $dataApiConnectionService->setUcid($expected);

        $actual = $this->paramUcid->getValue($dataApiConnectionService);

        $this->assertEquals($actual, $expected);
    }

    public function testSetHeaders_ShouldSetHeaders()
    {
        $expected = 'abc123';

        $dataApiConnectionService = new DataApiConnectionService();
        $dataApiConnectionService->setHeaders($expected);

        $actual = $this->paramHeaders->getValue($dataApiConnectionService);

        $this->assertEquals($actual, $expected);
    }

    public function testSetPostData_ShouldSetPostData()
    {
        $expected = 'abc123efg';

        $dataApiConnectionService = new DataApiConnectionService();
        $dataApiConnectionService->setPostData($expected);

        $actual = $this->paramPostData->getValue($dataApiConnectionService);

        $this->assertEquals($actual, $expected);
    }

}
