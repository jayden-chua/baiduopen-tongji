<?php

namespace BaiduOpen\Tongji\Interfaces\Services;

use BaiduOpen\Tongji\Interfaces\Helpers\iResponse;

interface iLogin
{
    /**
     * Perform prelogin
     *
     * @param string $userName
     * @param string $token
     *
     * @return iResponse
     */
    public function preLogin($userName, $token);

    /**
     * Perform login
     *
     * @param string $userName
     * @param string $password
     * @param string $token
     *
     * @return iResponse
     */
    public function doLogin($userName, $password, $token);

    /**
     * Perform logout
     *
     * @param string $userName
     * @param string $token
     * @param string $ucid
     * @param string $st
     *
     * @return iResponse
     */
    public function doLogout($userName, $token, $ucid, $st);
}
