<?php

namespace BaiduOpen\Tongji\Services;

use BaiduOpen\Tongji\Helpers\BaiduParams;
use BaiduOpen\Tongji\Interfaces\Helpers\iResponse;
use BaiduOpen\Tongji\Interfaces\Services\Connection\iDataApiConnection;
use BaiduOpen\Tongji\Services\Connection\DataApiConnectionService;
use BaiduOpen\Tongji\Helpers\BaiduResponse;

class ReportService extends ServiceInjector
{
    const DATA_API_CONNECTION_SERVICE = 'dataApiConnectionService';
    const RESPONSE_SERVICE = 'response';

    const VALID_SERVICES =  [
        self::DATA_API_CONNECTION_SERVICE => iDataApiConnection::class,
        self::RESPONSE_SERVICE => iResponse::class
    ];

    const DEFAULT_SERVICES = [
        self::DATA_API_CONNECTION_SERVICE => DataApiConnectionService::class,
        self::RESPONSE_SERVICE => BaiduResponse::class
    ];

    /**
     * @var string
     */
    private $apiUrl;

    /**
     * @var string
     */
    private $userName;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $ucid;

    /**
     * @var string
     */
    private $st;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var iDataApiConnection
     */
    public $dataApiConnectionService;

    /**
     * @var iResponse
     */
    public $response;

    /**
     * construct
     *
     * @param string $apiUrl
     * @param string $userName
     * @param string $token
     * @param string $ucid
     * @param string $st
     * @param string $uuid
     */
    public function __construct($apiUrl, $userName, $token, $ucid, $st, $uuid)
    {
        $this->setApiUrl($apiUrl);
        $this->setUserName($userName);
        $this->setToken($token);
        $this->setUcid($ucid);
        $this->setSt($st);
        $this->setUuid($uuid);

        $this->init();
    }

    /**
     * Get sitelist
     *
     * @return array
     */
    public function getSiteList()
    {
        $this->dataApiConnectionService->init(
            $this->getApiUrl() . '/getSiteList',
            $this->getUuid()
        );

        $apiConnectionData = [
            'header' => [
                'username' => $this->getUserName(),
                'password' => $this->getSt(),
                'token' => $this->getToken(),
                'account_type' => '1',
            ],
            'body' => null,
        ];

        $this->dataApiConnectionService->send($apiConnectionData);

        return [
            'header' => $this->dataApiConnectionService->getRetHead(),
            'body' => $this->dataApiConnectionService->getRetBody(),
            'raw' => $this->dataApiConnectionService->getRetRaw(),
        ];
    }

    /**
     * @param $siteId
     * @param $startTime
     * @param $endTime
     * @return iResponse
     */
    public function getLatestTrendByDay($siteId, $startTime, $endTime)
    {
        $response = $this->getData([
            'site_id' => $siteId,
            'method' => 'trend/latest/a',
            'start_date' => $startTime,
            'end_date' => $endTime,
            'max_results' => 0,
            'gran' => 'day',
            'order' => 'start_time,asc'
        ]);

        if ($response->isSuccess()) {
            $returnData = $response->getApiData();
            $response->setData([
                'general' => $returnData['body']['data'][0]['result']['items'][0],
                'specific' => $returnData['body']['data'][0]['result']['items'][1],
            ]);
        }

        return $response;
    }

    /**
     * @param $siteId
     * @param $startTime
     * @param $endTime
     * @return iResponse
     */
    public function getOverviewTimeTrendByDay($siteId, $startTime, $endTime)
    {
        $dataArray = $this->prepareMethodParams(
            BaiduParams::METHOD_OVERVIEW_GET_TIME_TREND_REPORT,
            $siteId,
            $startTime,
            $endTime,
            'day'
        );

        $response = $this->getData($dataArray);
        return $response;
    }

    /**
     * @param $siteId
     * @param $startTime
     * @param $endTime
     * @return iResponse
     */
    public function getOverviewDistrictByDay($siteId, $startTime, $endTime)
    {
        $dataArray = $this->prepareMethodParams(
            BaiduParams::METHOD_OVERVIEW_GET_DISTRICT_REPORT,
            $siteId,
            $startTime,
            $endTime,
            'day'
        );

        $response = $this->getData($dataArray);

        return $response;
    }

    /**
     * @param $siteId
     * @param $startTime
     * @param $endTime
     * @return iResponse
     */
    public function getOverviewCommonTrackByDay($siteId, $startTime, $endTime)
    {
        $dataArray = $this->prepareMethodParams(
            BaiduParams::METHOD_OVERVIEW_GET_COMMON_TRACK_REPORT,
            $siteId,
            $startTime,
            $endTime,
            'day'
        );

        $response = $this->getData($dataArray);

        return $response;
    }

    /**
     * @param $siteId
     * @param $startTime
     * @param $endTime
     * @return iResponse
     */
    public function getProProductByDay($siteId, $startTime, $endTime)
    {
        $dataArray = $this->prepareMethodParams(
            BaiduParams::METHOD_PRO_PRODUCT_A,
            $siteId,
            $startTime,
            $endTime,
            'day'
        );

        $response = $this->getData($dataArray);

        return $response;
    }

    /**
     * @param $siteId
     * @param $startTime
     * @param $endTime
     * @return iResponse
     */
    public function getTrendTimeByDay($siteId, $startTime, $endTime)
    {
        $dataArray = $this->prepareMethodParams(
            BaiduParams::METHOD_TREND_TIME_A,
            $siteId,
            $startTime,
            $endTime,
            'day'
        );

        $response = $this->getData($dataArray);

        return $response;
    }

    /**
     * @param $siteId
     * @param $startTime
     * @param $endTime
     * @return iResponse
     */
    public function getProHourByDay($siteId, $startTime, $endTime)
    {
        $dataArray = $this->prepareMethodParams(
            BaiduParams::METHOD_PRO_HOUR_A,
            $siteId,
            $startTime,
            $endTime,
            'day'
        );

        $response = $this->getData($dataArray);

        return $response;
    }

    /**
     * @param $siteId
     * @param $startTime
     * @param $endTime
     * @return iResponse
     */
    public function getSourceAllByDay($siteId, $startTime, $endTime)
    {
        $dataArray = $this->prepareMethodParams(
            BaiduParams::METHOD_SOURCE_ALL_A,
            $siteId,
            $startTime,
            $endTime,
            'day'
        );

        $response = $this->getData($dataArray);

        return $response;
    }

    /**
     * @param $siteId
     * @param $startTime
     * @param $endTime
     * @return iResponse
     */
    public function getSourceEngineByDay($siteId, $startTime, $endTime)
    {
        $dataArray = $this->prepareMethodParams(
            BaiduParams::METHOD_SOURCE_ENGINE_A,
            $siteId,
            $startTime,
            $endTime,
            'day'
        );

        $response = $this->getData($dataArray);

        return $response;
    }

    /**
     * @param $siteId
     * @param $startTime
     * @param $endTime
     * @return iResponse
     */
    public function getSourceSearchwordByDay($siteId, $startTime, $endTime)
    {
        $dataArray = $this->prepareMethodParams(
            BaiduParams::METHOD_SOURCE_SEARCHWORD_A,
            $siteId,
            $startTime,
            $endTime,
            'day'
        );

        $response = $this->getData($dataArray);

        return $response;
    }

    /**
     * @param $siteId
     * @param $startTime
     * @param $endTime
     * @return iResponse
     */
    public function getSourceLinkByDay($siteId, $startTime, $endTime)
    {
        $dataArray = $this->prepareMethodParams(
            BaiduParams::METHOD_SOURCE_LINK_A,
            $siteId,
            $startTime,
            $endTime,
            'day'
        );

        $response = $this->getData($dataArray);

        return $response;
    }

    /**
     * @param $siteId
     * @param $startTime
     * @param $endTime
     * @return iResponse
     */
    public function getVisitToppageByDay($siteId, $startTime, $endTime)
    {
        $dataArray = $this->prepareMethodParams(
            BaiduParams::METHOD_VISIT_TOPPAGE_A,
            $siteId,
            $startTime,
            $endTime,
            'day'
        );

        $response = $this->getData($dataArray);

        return $response;
    }

    /**
     * @param $siteId
     * @param $startTime
     * @param $endTime
     * @return iResponse
     */
    public function getVisitLandingPageByDay($siteId, $startTime, $endTime)
    {
        $dataArray = $this->prepareMethodParams(
            BaiduParams::METHOD_SOURCE_LINK_A,
            $siteId,
            $startTime,
            $endTime,
            'day'
        );

        $response = $this->getData($dataArray);

        return $response;
    }

    /**
     * @param $siteId
     * @param $startTime
     * @param $endTime
     * @return iResponse
     */
    public function getVisitTopDomainByDay($siteId, $startTime, $endTime)
    {
        $dataArray = $this->prepareMethodParams(
            BaiduParams::METHOD_VISIT_TOPDOMAIN_A,
            $siteId,
            $startTime,
            $endTime,
            'day'
        );

        $response = $this->getData($dataArray);

        return $response;
    }

    /**
     * @param $siteId
     * @param $startTime
     * @param $endTime
     * @return iResponse
     */
    public function getVisitDistrictByDay($siteId, $startTime, $endTime)
    {
        $dataArray = $this->prepareMethodParams(
            BaiduParams::METHOD_VISIT_DISTRICT_A,
            $siteId,
            $startTime,
            $endTime,
            'day'
        );

        $response = $this->getData($dataArray);

        return $response;
    }

    /**
     * @param $siteId
     * @param $startTime
     * @param $endTime
     * @return iResponse
     */
    public function getVisitWorldByDay($siteId, $startTime, $endTime)
    {
        $dataArray = $this->prepareMethodParams(
            BaiduParams::METHOD_VISIT_WORLD_A,
            $siteId,
            $startTime,
            $endTime,
            'day'
        );

        $response = $this->getData($dataArray);

        return $response;
    }

    /**
     * get data
     *
     * @param array $parameters
     *
     * @return iResponse
     */
    public function getData($parameters)
    {
        $this->response->reset();

        $this->dataApiConnectionService->init(
            $this->getApiUrl() . '/getData',
            $this->getUuid()
        );

        $apiConnectionData = [
            'header' => [
                'username' => $this->getUserName(),
                'password' => $this->getSt(),
                'token' => $this->getToken(),
                'account_type' => '1',
            ],
            'body' => $parameters,
        ];
        $this->dataApiConnectionService->send($apiConnectionData);

        $apiResponse = [
            'header' => $this->dataApiConnectionService->getRetHead(),
            'body' => $this->dataApiConnectionService->getRetBody(),
            'raw' => $this->dataApiConnectionService->getRetRaw(),
        ];

        $headerResponse = $this->dataApiConnectionService->getRetHead();
        $this->response->setApiStatus('Success');

        if ($headerResponse['desc'] !== 'success') {
            $this->response->setApiStatus('Failed');
            $this->response->setApiMessage($headerResponse['failures']);
        }

        $this->response->setApiData($apiResponse);
        return $this->response;
    }

    public function init()
    {
        $this->initDefaultServices(self::DEFAULT_SERVICES, self::VALID_SERVICES);
        $this->dataApiConnectionService->setUcid($this->getUcid());
    }

    /**
     * @return string
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    /**
     * @param string $apiUrl
     */
    public function setApiUrl($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getUcid()
    {
        return $this->ucid;
    }

    /**
     * @param string $ucid
     */
    public function setUcid($ucid)
    {
        $this->ucid = $ucid;
    }

    /**
     * @return string
     */
    public function getSt()
    {
        return $this->st;
    }

    /**
     * @param string $st
     */
    public function setSt($st)
    {
        $this->st = $st;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @param $method
     * @param $siteId
     * @param $startTime
     * @param $endTime
     * @param $gran
     * @return bool|array
     */
    public function prepareMethodParams($method, $siteId, $startTime, $endTime, $gran)
    {
        if (in_array($method, BaiduParams::DEFAULT_METHOD_METRICS)) {
            $dataArray = BaiduParams::DEFAULT_METHOD_METRICS[$method];
            $dataArray['site_id'] = $siteId;
            $dataArray['start_date'] = $startTime;
            $dataArray['end_date'] = $endTime;
            $dataArray['gran'] = $gran;
            return $dataArray;
        }

        return false;
    }
}
