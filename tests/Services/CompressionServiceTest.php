<?php

namespace BaiduOpen\Tests\Tongji\Services;

use BaiduOpen\Tongji\Services\CompressionService;
use PHPUnit\Framework\TestCase;

class CompressionServiceTest extends TestCase
{
    private $clearData;
    private $zippedData;

    public function setUp()
    {
        $this->clearData = '{"needAuthCode":false,"authCode":null}';
        $this->zippedData = gzencode($this->clearData);
    }

    public function testDecode_ShouldDecodeAsExpected()
    {
        $compressionService = new CompressionService();
        $unzippedData = $compressionService->decode($this->zippedData);

        $this->assertSame($this->clearData, $unzippedData);
    }
}
