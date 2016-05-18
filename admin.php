<?php

namespace OCA\AppOrder;

use \OCA\AppOrder\AppInfo\Application;

$app = new Application(array(), \OC::$server->getNavigationManager());
$response = $app->getContainer()->query('\OCA\AppOrder\Controller\SettingsController')->adminIndex();
return $response->render();
