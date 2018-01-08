<?php

namespace BaiduOpen\Tongji\Interfaces\Services\Connection;

interface iDataApiConnection extends iApiConnection
{
    /**
     * Set ucid
     *
     * @param $ucid
     */
    public function setUcid($ucid);

    /**
     * @return array
     */
    public function getRetHead();

    /**
     * @return array
     */
    public function getRetBody();

    /**
     * @return string
     */
    public function getRetRaw();
}
