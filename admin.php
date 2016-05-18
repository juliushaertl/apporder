<?php

namespace OCA\AppOrder;

use \OCA\AppOrder\AppInfo\Application;

$app = new Application();
$response = $app->getContainer()->query('\OCA\AppOrder\Controller\SettingsController')->adminIndex();
return $response->render();
