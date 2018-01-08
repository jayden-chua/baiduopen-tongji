<?php

namespace BaiduOpen\Tongji\Interfaces\Services\Connection;

interface iApiConnection
{
    /**
     * init
     *
     * @param string $url
     * @param string $ucid
     */
    public function init($url, $ucid);

    /**
     * generate post data
     *
     * @param array $data
     */
    public function genPostData($data);

    /**
     * post
     *
     * @param array $data
     */
    public function send($data);
}
