<?php

namespace BaiduOpen\Tongji\Services;

use BaiduOpen\Tongji\Interfaces\Helpers\iResponse;
use BaiduOpen\Tongji\Interfaces\Services\iLogin;
use BaiduOpen\Tongji\Interfaces\Services\iCompression;
use BaiduOpen\Tongji\Interfaces\Services\Connection\iLoginConnection;
use BaiduOpen\Tongji\Services\Connection\LoginConnectionService;
use BaiduOpen\Tongji\Helpers\BaiduParams;
use BaiduOpen\Tongji\Helpers\BaiduResponse;

class LoginService
    extends ServiceInjector
    implements iLogin
{
    const COMPRESSION_SERVICE = 'compressionService';
    const LOGIN_CONNECTION_SERVICE = 'loginConnectionService';
    const RESPONSE_SERVICE = 'response';

    const VALID_SERVICES =  [
        self::COMPRESSION_SERVICE => iCompression::class,
        self::LOGIN_CONNECTION_SERVICE => iLoginConnection::class,
        self::RESPONSE_SERVICE => iResponse::class
    ];

    const DEFAULT_SERVICES = [
        self::COMPRESSION_SERVICE => CompressionService::class,
        self::LOGIN_CONNECTION_SERVICE => LoginConnectionService::class,
        self::RESPONSE_SERVICE => BaiduResponse::class
    ];

    /**
     * @var string
     */
    private $loginUrl;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var iCompression
     */
    public $compressionService;

    /**
     * @var iLoginConnection
     */
    public $loginConnectionService;

    /**
     * @var iResponse
     */
    public $response;

    /**
     * LoginService constructor.
     * @param $uuid
     */
    public function __construct($uuid)
    {
        $this->loginUrl = BaiduParams::LOGIN_URL;
        $this->uuid = $uuid;
        $this->init();
    }

    /**
     * Perform prelogin
     *
     * @param string $userName
     * @param string $token
     *
     * @return iResponse
     */
    public function preLogin($userName, $token)
    {
        $this->response->reset();
        $preLoginData = [
            'username' => $userName,
            'token' => $token,
            'functionName' => 'preLogin',
            'uuid' => $this->uuid,
            'request' => [
                'osVersion' => 'windows',
                'deviceType' => 'pc',
                'clientVersion' => '1.0',
            ],
        ];

        $this->loginConnectionService->send($preLoginData);
        $this->response->setApiStatus('Failed');

        if ($this->loginConnectionService->getReturnCode() === 0) {
            $retData = $this->compressionService->decode($this->loginConnectionService->getRetData());
            $retArray = json_decode($retData, true);
            $this->response->setApiData($retArray);

            if (!isset($retArray['needAuthCode']) || $retArray['needAuthCode'] === true) {
                $this->response->setApiMessage('preLogin return data format error: {$retData}');
                return $this->response;
            } elseif ($retArray['needAuthCode'] === false) {
                $this->response->setApiStatus('Success');
                $this->response->setApiMessage('preLogin successful');
                return $this->response;
            }

            $this->response->setApiMessage('unexpected preLogin return data: {$retData}');
            return $this->response;
        }

        $this->response->setApiMessage('preLogin failed with return code: {$this->loginConnectionService->getReturnCode()}');
        return $this->response;
    }

    /**
     * Perform login
     *
     * @param string $userName
     * @param string $password
     * @param string $token
     *
     * @return iResponse
     */
    public function doLogin($userName, $password, $token)
    {
        $this->response->reset();
        $doLoginData = [
            'username' => $userName,
            'token' => $token,
            'functionName' => 'doLogin',
            'uuid' => $this->uuid,
            'request' => [
                'password' => $password,
            ],
        ];
        $this->loginConnectionService->send($doLoginData);
        $this->response->setApiStatus('Failed');

        if ($this->loginConnectionService->getReturnCode() === 0) {
            $retData = gzinflate(substr($this->loginConnectionService->getRetData(), 10, -8));
            $retArray = json_decode($retData, true);
            if (!isset($retArray['retcode']) || !isset($retArray['ucid']) || !isset($retArray['st'])) {
                $this->response->setApiMessage("doLogin return data format error: {$retData}");
                return $this->response;
            } elseif ($retArray['retcode'] === 0) {
                $this->response->setApiStatus('Success');
                $this->response->setApiMessage('doLogin successful');
                $this->response->setData(['ucid' => $retArray['ucid'], 'st' => $retArray['st']]);
                return $this->response;
            }

            $this->response->setApiMessage("doLogin unsuccessfully with retcode: {$retArray['retcode']}");
            return $this->response;
        }

        $this->response->setApiMessage("doLogin unsuccessfully with return code: {$this->loginConnectionService->getReturnCode()}");
        return $this->response;
    }

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
    public function doLogout($userName, $token, $ucid, $st)
    {
        $this->response->reset();
        $doLogoutData = [
            'username' => $userName,
            'token' => $token,
            'functionName' => 'doLogout',
            'uuid' => $this->uuid,
            'request' => [
                'ucid' => $ucid,
                'st' => $st,
            ],
        ];

        $this->loginConnectionService->send($doLogoutData);
        $this->response->setApiStatus('Failed');

        if ($this->loginConnectionService->getReturnCode() === 0) {
            $retData = $this->compressionService->decode($this->loginConnectionService->getRetData());
            $retArray = json_decode($retData, true);
            if (!isset($retArray['retcode'])) {
                $this->response->setApiMessage("doLogout return data format error: {$retData}");
                return $this->response;
            } elseif ($retArray['retcode'] === 0) {
                $this->response->setApiStatus('Success');
                $this->response->setApiMessage('doLogout successful');
                return $this->response;
            }

            $this->response->setApiMessage("doLogout unsuccessfully with retcode: {$retArray['retcode']}");
            return $this->response;
        }

        $this->response->setApiMessage("doLogout unsuccessfully with return code: {$this->loginConnectionService->getReturnCode()}");
        return $this->response;
    }

    /**
     * Initializes services and the state of services.
     */
    public function init()
    {
        $this->initDefaultServices(self::DEFAULT_SERVICES, self::VALID_SERVICES, []);
        $this->loginConnectionService->init($this->loginUrl, $this->uuid);
    }
}
