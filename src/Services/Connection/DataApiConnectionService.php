<?php

namespace BaiduOpen\Tongji\Services\Connection;

use BaiduOpen\Tongji\Services\ServiceInjector;
use BaiduOpen\Tongji\Interfaces\Services\Connection\iDataApiConnection;

class DataApiConnectionService
    extends ServiceInjector
    implements iDataApiConnection
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $headers;

    /**
     * @var string
     */
    private $postData;

    /**
     * @var string
     */
    public $retHead;

    /**
     * @var string
     */
    public $retBody;

    /**
     * @var string
     */
    public $retRaw;

    /**
     * @var string
     */
    private $ucid = '';


    /**
     * init
     *
     * @param string $url
     * @param string $uuid
     */
    public function init($url, $uuid)
    {
        $this->setUrl($url);
        $this->setHeaders([
            'UUID: ' . $uuid,
            'USERID: ' . $this->getUcid(),
            'Content-Type:  data/json;charset=UTF-8'
        ]);
    }

    /**
     * generate post data
     *
     * @param array $data
     */
    public function genPostData($data)
    {
        $this->setPostData(json_encode($data));
    }

    /**
     * post
     *
     * @param array $data
     */
    public function send($data)
    {
        $this->genPostData($data);
        $isCurlSuccess = false;
        $curlError = 0;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->getUrl());
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->getPostData());
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $tmpRet = curl_exec($curl);
        $retry = 0;

        while(curl_errno($curl) == 28 && $retry < 5){
            echo '[error] CURL ERROR on DataConnection (' . $retry . '): ' . curl_error($curl) . PHP_EOL;
            $tmpRet = curl_exec($curl);
            $curlError = curl_errno($curl);
            $retry++;
        }

        if (!curl_errno($curl)) {
            $isCurlSuccess = true;
        }

        curl_close($curl);
        $tmpArray = json_decode($tmpRet, true);

        if ($isCurlSuccess) {
            if (isset($tmpArray['header']) && isset($tmpArray['body'])) {
                $this->setRetHead($tmpArray['header']);
                $this->setRetBody($tmpArray['body']);
                $this->setRetRaw($tmpRet);
            } else {
                $errArray['desc'] = 'service error';
                $errArray['failures'] = "SERVICE ERROR: {$tmpRet}";
                $this->setRetHead($errArray);
            }
        } else {
            $errArray['desc'] = 'CURL error';
            $errArray['failures'] = 'curl_error with errNo: ' . $curlError . " - {$tmpRet}";
            $this->setRetHead($errArray);
        }
    }

    /**
     * Get ucid
     *
     * @return mixed
     */
    public function getUcid()
    {
        return $this->ucid;
    }

    /**
     * Set ucid
     *
     * @param mixed $ucid
     */
    public function setUcid($ucid)
    {
        $this->ucid = $ucid;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return string
     */
    public function getPostData()
    {
        return $this->postData;
    }

    /**
     * @param string $postData
     */
    public function setPostData($postData)
    {
        $this->postData = $postData;
    }

    /**
     * @return string
     */
    public function getRetHead()
    {
        return $this->retHead;
    }

    /**
     * @param string $retHead
     */
    public function setRetHead($retHead)
    {
        $this->retHead = $retHead;
    }

    /**
     * @return string
     */
    public function getRetBody()
    {
        return $this->retBody;
    }

    /**
     * @param string $retBody
     */
    public function setRetBody($retBody)
    {
        $this->retBody = $retBody;
    }

    /**
     * @return string
     */
    public function getRetRaw()
    {
        return $this->retRaw;
    }

    /**
     * @param string $retRaw
     */
    public function setRetRaw($retRaw)
    {
        $this->retRaw = $retRaw;
    }
}
