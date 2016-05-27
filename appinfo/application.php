<?php

namespace OCA\AppOrder\AppInfo;

use \OCP\AppFramework\App;
use \OCA\AppOrder\Service\ConfigService;

class Application extends App {

    public function __construct(array $urlParams = array()) {
        parent::__construct('apporder', $urlParams);
        $container = $this->getContainer();
        $container->registerService('ConfigService', function($c) {
            return new ConfigService(
                $c->query('Config'),
                $c->query('AppName')
            );
        });

    }
}
