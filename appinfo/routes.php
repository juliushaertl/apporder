<?php

namespace OCA\AppOrder;
$app = new AppInfo\Application();
$app->registerRoutes($this, [
    'routes' => [
        ['name' => 'settings#getOrder', 'url' => 'ajax/order.php', 'verb' => 'GET'],
        ['name' => 'settings#savePersonal', 'url' => 'ajax/personal.php', 'verb' => 'GET'],
        ['name' => 'settings#saveDefaultOrder', 'url' => 'ajax/admin.php', 'verb' => 'GET'],
    ]
]);
