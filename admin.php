<?php

namespace OCA\AppOrder;

use \OCA\AppOrder\AppInfo\Application;

$app = new Application(array());
$response = $app->getContainer()->query('\OCA\AppOrder\Controller\SettingsController')->adminIndex();
return $response->render();
