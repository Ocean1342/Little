<?php

use Little\Application;
use Little\HTTP\Request;

ini_set('display_errors', '1');

require __DIR__ . '/../vendor/autoload.php';

$request = new Request($_SERVER['REQUEST_URI'],$_SERVER['REQUEST_METHOD'],$_POST);
$config = require __DIR__ . '/../config/config.php';

$app = new Application($config);
return $app->handle($request)->send();
