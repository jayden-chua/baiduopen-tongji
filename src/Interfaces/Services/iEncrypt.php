<?php

namespace BaiduOpen\Tongji\Interfaces\Services;

interface iEncrypt
{
    /**
     * setup public key
     *
     * @return bool
     */
    public function setupPublicKey();

    /**
     * pub encrypt
     *
     * @param string $data
     *
     * @return string
     */
    public function pubEncrypt($data);
}
