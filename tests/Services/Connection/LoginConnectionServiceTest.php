<?php

namespace BaiduOpen\Tests\Tongji\Services\Connection;

use BaiduOpen\Tongji\Services\Connection\LoginConnectionService;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionProperty;
use Zend\Mail\Protocol\Smtp\Auth\Login;

class LoginConnectionServiceTest extends TestCase
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
     * @var LoginConnectionService
     */
    public $loginConnectionService;

    public function setUp()
    {
        $this->reflector = new ReflectionClass(LoginConnectionService::class);
        $this->paramUrl = $this->reflector->getProperty('url');
        $this->paramUrl->setAccessible(true);

        $this->paramHeaders = $this->reflector->getProperty('headers');
        $this->paramHeaders->setAccessible(true);

        $this->loginConnectionService = new LoginConnectionService();
    }

    public function testInit_ShouldSetParameters()
    {
        $this->loginConnectionService->init('abc', 'def');

        $actualUrl = $this->paramUrl->getValue($this->loginConnectionService);
        $actualHeaders = $this->paramHeaders->getValue($this->loginConnectionService);

        $expectedUrl = 'abc';
        $expectedHeaders = [
            'UUID: def',
            'account_type: 1',
            'Content-Type:  data/gzencode and rsa public encrypt;charset=UTF-8'
        ];

        $this->assertEquals($expectedUrl, $actualUrl);
        $this->assertEquals($expectedHeaders, $actualHeaders);
    }
}