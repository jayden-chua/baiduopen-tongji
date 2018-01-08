<?php

namespace BaiduOpen\Tongji\Services;

use BaiduOpen\Tongji\Interfaces\Services\iCompression;

class CompressionService
    extends ServiceInjector
    implements iCompression
{
    /**
     * Decodes using gzip
     *
     * @param string $data
     *
     * @return string
     */
    public function decode($data)
    {
        $flags = ord(substr($data, 3, 1));
        $headerLen = 10;
        if ($flags & 4) {
            $extraLen = unpack('v', substr($data, 10, 2));
            $extraLen = $extraLen[1];
            $headerLen += 2 + $extraLen;
        }
        if ($flags & 8) {
            $headerLen = strpos($data, chr(0), $headerLen) + 1;
        }
        if ($flags & 16) {
            $headerLen = strpos($data, chr(0), $headerLen) + 1;
        }
        if ($flags & 2) {
            $headerLen += 2;
        }
        $unpacked = @gzinflate(substr($data, $headerLen));
        if ($unpacked === false) {
            $unpacked = $data;
        }
        return $unpacked;
    }
}
