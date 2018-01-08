<?php

namespace BaiduOpen\Tests\Tongji\Services;

use BaiduOpen\Tongji\Services\RsaIEncryptService;
use ReflectionClass;
use ReflectionProperty;
use PHPUnit\Framework\TestCase;

class RsaIEncryptServiceTest extends TestCase
{
    /**
     * @var ReflectionClass
     */
    private $reflector;

    /**
     * @var ReflectionProperty
     */
    private $paramPublicKey;

    public function setUp()
    {
        $this->reflector = new ReflectionClass(RsaIEncryptService::class);
        $this->paramPublicKey = $this->reflector->getProperty('publicKey');
        $this->paramPublicKey->setAccessible(true);
    }

    public function testSetupPublicKey_ShouldSetResource()
    {
        $rsaEncryptService = new RsaIEncryptService();
        $rsaEncryptService->setupPublicKey();

        $this->assertTrue(is_resource($this->paramPublicKey->getValue($rsaEncryptService)));
    }

    public function testPubEncrypt_ShouldReturnNull_WhenDataIsNotString()
    {
        $rsaEncryptService = new RsaIEncryptService();
        $rsaEncryptService->setupPublicKey();
        $encryptedResult = $rsaEncryptService->pubEncrypt([]);
        $this->assertNull($encryptedResult);
    }

    public function testPubEncrypt_ShouldReturnString_WhenDataIsString()
    {
        $rsaEncryptService = new RsaIEncryptService();
        $rsaEncryptService->setupPublicKey();
        $encryptedResult = $rsaEncryptService->pubEncrypt('abc');

        $this->assertTrue(is_string($encryptedResult));
    }

    public function testGetPublicKey_ShouldReturnPublicKey_WhenInvoked()
    {
        $rsaEncryptService = new RsaIEncryptService();
        $rsaEncryptService->setupPublicKey();
        $actual = $rsaEncryptService->getPublicKey();
        $expected = $this->paramPublicKey->getValue($rsaEncryptService);
        $this->assertEquals($actual, $expected);
    }
}