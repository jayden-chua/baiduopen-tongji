<?php

namespace BaiduOpen\Tongji\Interfaces\Services;

interface iCompression
{
    /**
     * Decodes data
     *
     * @param string $data
     *
     * @return string
     */
    public function decode($data);
}
