<?php

namespace BaiduOpen\Tongji\Services;

use ReflectionClass;

abstract class ServiceInjector
{
    public $validServices;

    public $servicesParams;

    /**
     * Initializes default services
     *
     * @param array $defaultServices
     * @param array $validServices
     * @param array $servicesParams
     */
    public function initDefaultServices($defaultServices, $validServices, $servicesParams = [])
    {
        $this->validServices = $validServices;
        $this->servicesParams = $servicesParams;
        $this->setServices($defaultServices);
    }

    /**
     * Sets services
     *
     * @param $services
     */
    public function setServices($services)
    {
        foreach ($services as $serviceName => $serviceClassName) {
            // Checks if the service is a valid service that is required in the class
            // Also checks if the service has implemented a valid interface
            if (isset($this->validServices[$serviceName]) && in_array($this->validServices[$serviceName], class_implements($serviceClassName))) {
                $serviceParam = isset($this->servicesParams[$serviceName]) ? $this->servicesParams[$serviceName] : [];
                $this->setService($serviceName, $serviceClassName, $serviceParam);
            }
        }
    }

    /**
     * Sets single service
     *
     * @param string $serviceName
     * @param string $serviceClassName
     * @param array $params
     */
    public function setService($serviceName, $serviceClassName, $params = [])
    {
        if (!empty($params)) {
            $reflectionClass = new ReflectionClass($serviceClassName);
            $this->$serviceName = $reflectionClass->newInstanceArgs($params);
        } else {
            $this->$serviceName = new $serviceClassName();
        }
    }
}
