<?php


use Little\Application;
use Little\Migrations\CreateLinksTable;

require 'vendor/autoload.php';

$config = require __DIR__ . '/config/config.php';
$app = new Application($config);

$migration = new CreateLinksTable($app->dbConnection);
$method = $argv[1];
$migration->$method();