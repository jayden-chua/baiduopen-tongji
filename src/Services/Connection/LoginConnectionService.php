<?php

namespace BaiduOpen\Tongji\Services\Connection;

use BaiduOpen\Tongji\Interfaces\Services\Connection\iLoginConnection;
use BaiduOpen\Tongji\Services\RsaIEncryptService;
use BaiduOpen\Tongji\Services\ServiceInjector;
use BaiduOpen\Tongji\Interfaces\Services\iEncrypt;

class LoginConnectionService
    extends ServiceInjector
    implements iLoginConnection
{
    const ENCRYPT_SERVICE = 'encryptService';

    const VALID_SERVICES =  [
        self::ENCRYPT_SERVICE => iEncrypt::class
    ];

    const DEFAULT_SERVICES = [
        self::ENCRYPT_SERVICE => RsaIEncryptService::class
    ];

    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var string
     */
    private $postData;

    /**
     * @var iEncrypt
     */
    public $encryptService;

    /**
     * @var int
     */
    public $returnCode;

    /**
     * @var string
     */
    public $retData;

    public function __construct()
    {
        $this->initDefaultServices(self::DEFAULT_SERVICES, self::VALID_SERVICES);
    }

    /**
     * Initialize
     *
     * @param string $url
     * @param string $uuid
     */
    public function init($url, $uuid)
    {
        $this->setUrl($url);
        $this->setHeaders([
            'UUID: ' . $uuid,
            'account_type: 1',
            'Content-Type:  data/gzencode and rsa public encrypt;charset=UTF-8'
        ]);
    }

    /**
     * Generate and set postData
     *
     * @param array $data
     */
    public function genPostData($data)
    {
        $gzData = gzencode(json_encode($data), 9);
        for ($index = 0, $enData = ''; $index < strlen($gzData); $index += 117) {
            $gzPackData = substr($gzData, $index, 117);
            $enData .= $this->encryptService->pubEncrypt($gzPackData);
        }
        $this->setPostData($enData);
    }

    /**
     * Send data via CURL
     *
     * @param array $data
     */
    public function send($data)
    {
        $this->genPostData($data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getPostData());
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $tmpInfo = curl_exec($curl);
        $retry = 0;

        while(curl_errno($curl) == 28 && $retry < 5){
            echo '[error] CURL ERROR on LoginConnection: (' . $retry . '): ' . curl_error($curl) . PHP_EOL;
            $tmpInfo = curl_exec($curl);
            $retry++;
        }

        curl_close($curl);

        $this->setReturnCode(ord($tmpInfo[0]) * 64 + ord($tmpInfo[1]));

        if ($this->getReturnCode() === 0) {
            $this->setRetData(substr($tmpInfo, 8));
        }
    }

    /**
     * Get returnCode
     *
     * @return string
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }

    /**
     * Set returnCode
     *
     * @param int $returnCode
     */
    public function setReturnCode($returnCode)
    {
        $this->returnCode = $returnCode;
    }

    /**
     * Get retData
     *
     * @return string
     */
    public function getRetData()
    {
        return $this->retData;
    }

    /**
     * Set retData
     *
     * @param string $retData
     */
    public function setRetData($retData)
    {
        $this->retData = $retData;
    }

    /**
     * Get postData
     *
     * @return string
     */
    public function getPostData()
    {
        return $this->postData;
    }

    /**
     * Set postData
     * @param string $postData
     */
    public function setPostData($postData)
    {
        $this->postData = $postData;
    }

    /**
     * Get headers
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set headers
     *
     * @param array $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}
