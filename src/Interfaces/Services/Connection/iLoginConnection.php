<?php

namespace BaiduOpen\Tongji\Interfaces\Services\Connection;

interface iLoginConnection extends iApiConnection
{
    /**
     * Get returnCode
     *
     * @return string
     */
    public function getReturnCode();

    /**
     * Set returnCode
     *
     * @param string $returnCode
     */
    public function setReturnCode($returnCode);

    /**
     * Get retData
     *
     * @return string
     */
    public function getRetData();

    /**
     * Set retData
     *
     * @param string $retData
     */
    public function setRetData($retData);
}
