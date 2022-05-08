<?php

$dbConnection = require __DIR__ . '/app/db.config.php';

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/src/Little/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/src/Little/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'mysql',
            'host' => $dbConnection['production']['host'],
            'name' => $dbConnection['production']['dbname'],
            'user' => $dbConnection['production']['user'],
            'pass' => $dbConnection['production']['password'],
            'port' => '3306',
            'charset' => 'utf8',
        ]
/*        'testing' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'testing_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ]*/
    ],
    'version_order' => 'creation'
];
