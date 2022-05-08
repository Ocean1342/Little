<?php


$arDbConfig = [
    'production' => [
        'dbname' => 'little',
        'host' => 'mysql',
        'user' => 'root',
        'password' => 'root'
    ]
];

$arDbConfig['production']['dsn'] = 'mysql:host=' .
    $arDbConfig['production']['host'] . ';dbname=' . $arDbConfig['production']['dbname'];

return $arDbConfig;
