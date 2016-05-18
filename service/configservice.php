<?php

namespace OCA\AppOrder\Service;

use \OCP\IConfig;

class ConfigService {

    private $config;
    private $appName;

    public function __construct(IConfig $config, $appName){
        $this->config = $config;
        $this->appName = $appName;
    }

    public function getAppValue($key) {
        return $this->config->getAppValue($this->appName, $key);
    }

    public function setAppValue($key, $value) {
        $this->config->setAppValue($this->appName, $key, $value);
    }

    public function getUserValue($key, $userId) {
        return $this->config->getUserValue($userId, $this->appName, $key);
    }

    public function setUserValue($key, $userId, $value) {
        $this->config->setUserValue($userId, $this->appName, $key, $value);
    }

}
