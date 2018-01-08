<?php

namespace BaiduOpen\Tongji\Helpers;

use BaiduOpen\Tongji\Interfaces\Helpers\iResponse;

class BaiduResponse implements iResponse
{
    /**
     * @var string
     */
    public $apiStatus;

    /**
     * @var array
     */
    public $apiData = [];

    /**
     * @var array
     */
    public $apiMessage;

    /**
     * @var array
     */
    public $data = [];

    /**
     * Get API status
     *
     * @return string
     */
    public function getApiStatus()
    {
        return $this->apiStatus;
    }

    /**
     * Set API status
     *
     * @param $apiStatus
     */
    public function setApiStatus($apiStatus)
    {
        $this->apiStatus = $apiStatus;
    }

    /**
     * Check if API status is successful
     *
     * @return bool
     */
    public function isSuccess()
    {
        if ($this->getApiStatus() === 'Success') {
            return true;
        }

        return false;
    }

    /**
     * Set API return data
     *
     * @param $apiData
     */
    public function setApiData($apiData)
    {
        $this->apiData = $apiData;
    }

    /**
     * Get API data
     *
     * @return array
     */
    public function getApiData()
    {
        return $this->apiData;
    }

    /**
     * Set API message
     *
     * @param $apiMessage
     */
    public function setApiMessage($apiMessage)
    {
        $this->apiMessage = $apiMessage;
    }

    /**
     * Get API message
     *
     * @return array|string
     */
    public function getApiMessage()
    {
        return $this->apiMessage;
    }

    /**
     * Get Data, other than API data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set Data, this can be used to set data other than Api data
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return $this
     */
    public function reset()
    {
        $this->setApiStatus('');
        $this->setApiMessage('');
        $this->setData([]);
        $this->setApiData([]);

        return $this;
    }
}
