<?php

namespace BaiduOpen\Tongji\Services;

use BaiduOpen\Tongji\Helpers\BaiduParams;
use BaiduOpen\Tongji\Helpers\BaiduResponse;
use BaiduOpen\Tongji\Interfaces\Helpers\iResponse;

class ServiceManager extends ServiceInjector
{
    const LOGIN_SERVICE = 'loginService';
    const DEFAULT_LOGIN_SERVICE = LoginService::class;

    const REPORT_SERVICE = 'reportService';
    const DEFAULT_REPORT_SERVICE = ReportService::class;

    const RESPONSE_SERVICE = 'response';

    const VALID_SERVICES =  [
        self::RESPONSE_SERVICE => iResponse::class
    ];

    const DEFAULT_SERVICES = [
        self::RESPONSE_SERVICE => BaiduResponse::class
    ];

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var null|string
     */
    private $ucid = null;

    /**
     * @var null|string
     */
    private $st = null;

    /**
     * @var bool
     */
    private $loginStatus = false;

    /**
     * @var bool
     */
    private $preloginStatus = false;

    /**
     * @var loginService
     */
    public $loginService;

    /**
     * @var ReportService
     */
    public $reportService;

    /**
     * @var iResponse
     */
    public $response;

    /**
     * ServiceManager constructor.
     *
     * @param $username
     * @param $password
     * @param $token
     * @param $uuid
     * @param null $loginService
     */
    public function __construct($username, $password, $token, $uuid, $loginService = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->token = $token;
        $this->uuid = $uuid;

        // Login Service is required to be instantiated before other services.
        $this->setService(
            self::LOGIN_SERVICE,
            self::DEFAULT_LOGIN_SERVICE,
            [$this->getUuid()]
        );

        if (!is_null($this->loginService)) {
            $getServiceParamsResponse = $this->getReportServiceParams();

            if ($getServiceParamsResponse !== false) {
                $this->setService(
                    self::REPORT_SERVICE,
                    self::DEFAULT_REPORT_SERVICE,
                    $getServiceParamsResponse
                );
            }

        }

        $this->initDefaultServices(self::DEFAULT_SERVICES, self::VALID_SERVICES);
    }

    /**
     * Login that combines both preLogin and doLogin
     *
     * @return iResponse
     */
    public function login()
    {
        $username = $this->getUsername();
        $password = $this->getPassword();
        $token = $this->getToken();

        $preLoginResponse = $this->loginService->preLogin($username, $token);
        $this->setPreloginStatus(true);

        if (!$preLoginResponse->isSuccess()) {
            $this->setPreloginStatus(false);
            return $preLoginResponse;
        }

        $loginResponse = $this->loginService->doLogin($username, $password, $token);
        $this->setLoginStatus(false);

        if ($loginResponse->isSuccess()) {
            $data = $loginResponse->getData();
            $this->setUcid($data['ucid']);
            $this->setSt($data['st']);
            $this->setLoginStatus(true);
        }

        return $loginResponse;
    }

    /**
     * Logout
     *
     * @return iResponse
     */
    public function logout()
    {
        $username = $this->getUsername();
        $token = $this->getToken();
        $ucid = $this->getUcid();
        $st = $this->getSt();

        return $this->loginService->doLogout($username, $token, $ucid, $st);
    }

    public function getReportServiceParams()
    {
        if (!$this->getUcid() || !$this->getSt()) {
            $loginResponse = $this->login();
            if (!$loginResponse->isSuccess()) {
                return $loginResponse->isSuccess();
            }
        }

        return [
            BaiduParams::REPORT_URL,
            $this->getUsername(),
            $this->getToken(),
            $this->getUcid(),
            $this->getSt(),
            $this->getUcid()
        ];
    }

    /**
     * Get username
     *
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username
     *
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get token
     *
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set token
     *
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * Get uuid
     *
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set uuid
     *
     * @param mixed $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * Checks if login
     *
     * @return bool
     */
    public function isLogin()
    {
        return $this->loginStatus;
    }

    /**
     * Sets loginStatus
     *
     * @param bool $loginStatus
     */
    public function setLoginStatus($loginStatus)
    {
        $this->loginStatus = $loginStatus;
    }

    /**
     * Checks is preLogin
     *
     * @return bool
     */
    public function isPrelogin()
    {
        return $this->preloginStatus;
    }

    /**
     * Sets preLogin status
     *
     * @param bool $preloginStatus
     */
    public function setPreloginStatus($preloginStatus)
    {
        $this->preloginStatus = $preloginStatus;
    }

    /**
     * Get password
     *
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password
     *
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
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
     * Get st
     *
     * @return mixed
     */
    public function getSt()
    {
        return $this->st;
    }

    /**
     * Set st
     *
     * @param mixed $st
     */
    public function setSt($st)
    {
        $this->st = $st;
    }
}
