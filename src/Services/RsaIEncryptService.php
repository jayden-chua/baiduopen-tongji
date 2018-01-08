<?php

namespace BaiduOpen\Tongji\Services;

use BaiduOpen\Tongji\Interfaces\Services\iEncrypt;
use BaiduOpen\Tongji\Helpers\BaiduParams;

class RsaIEncryptService
    extends ServiceInjector
    implements iEncrypt
{
    /**
     * @var string
     */
    private $publicKey;

    /**
     * setup public key
     *
     * @return bool
     */
    public function setupPublicKey()
    {
        if (is_resource($this->publicKey)) {
            return true;
        }
        $puk = BaiduParams::DEFAULT_API_PUB_KEY;
        $this->publicKey = openssl_pkey_get_public($puk);
        return true;
    }

    /**
     * pub encrypt
     *
     * @param string $data
     *
     * @return string
     */
    public function pubEncrypt($data)
    {
        if (!is_string($data)) {
            return null;
        }
        $encrypted = '';
        $this->setupPublicKey();
        $ret = openssl_public_encrypt($data, $encrypted, $this->publicKey);
        if ($ret) {
            return $encrypted;
        }

        return null;
    }

    /**
     * Get public key
     *
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }
}