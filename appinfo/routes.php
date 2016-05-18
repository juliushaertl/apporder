<?php

namespace OCA\AppOrder;
$application = new \OCA\AppOrder\AppInfo\Application();
$application->registerRoutes($this, [
    'routes' => [
        ['name' => 'settings#getOrder', 'url' => 'ajax/order.php', 'verb' => 'GET'],
        ['name' => 'settings#savePersonal', 'url' => 'ajax/personal.php', 'verb' => 'GET'],
        ['name' => 'settings#saveDefaultOrder', 'url' => 'ajax/admin.php', 'verb' => 'GET'],
    ]
]);
