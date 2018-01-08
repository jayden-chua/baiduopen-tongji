<?php

namespace BaiduOpen\Tongji\Interfaces\Helpers;

interface iResponse
{
    /**
     * Get API status
     *
     * @return string
     */
    public function getApiStatus();

    /**
     * Set API status
     *
     * @param $apiStatus
     */
    public function setApiStatus($apiStatus);

    /**
     * Check if API status is successful
     *
     * @return bool
     */
    public function isSuccess();

    /**
     * Set API return data
     *
     * @param $apiData
     */
    public function setApiData($apiData);

    /**
     * Get API data
     *
     * @return array
     */
    public function getApiData();

    /**
     * Set API message
     *
     * @param $apiMessage
     */
    public function setApiMessage($apiMessage);

    /**
     * Get API message
     *
     * @return array|string
     */
    public function getApiMessage();

    /**
     * Get Data, other than API data
     *
     * @return array
     */
    public function getData();

    /**
     * Set Data, this can be used to set data other than Api data
     * @param array $data
     */
    public function setData($data);

    /**
     * Resets data
     *
     * @return $this
     */
    public function reset();
}