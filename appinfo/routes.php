<?php

return [
    'routes' => [
		['name' => 'app#index', 'url' => '/', 'verb' => 'GET'],
        ['name' => 'settings#getOrder', 'url' => 'ajax/order.php', 'verb' => 'GET'],
        ['name' => 'settings#savePersonal', 'url' => 'ajax/personal.php', 'verb' => 'GET'],
        ['name' => 'settings#saveDefaultOrder', 'url' => 'ajax/admin.php', 'verb' => 'GET'],
    ]
];
