<?php

use Core\Config;

return [
    'database' => [
        'host' => Config::get("host") ?? 'localhost',
        'port' => Config::get("port") ?? 3306,
        'dbname' => Config::get("dbname") ?? 'blogsoftware',
        'charset' => 'utf8mb4'
    ],

    'services' => [

    ],
];