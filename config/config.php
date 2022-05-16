<?php


$config = [
    'dbConnection' => [
        'dbname' => 'little',
        'host' => 'mysql',
        'user' => 'root',
        'password' => 'root'
    ]
];

$config['dbConnection']['dsn'] = 'mysql:host=' .
    $config['dbConnection']['host'] . ';dbname=' . $config['dbConnection']['dbname'];

return $config;
