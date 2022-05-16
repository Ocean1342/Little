<?php

use Little\Application;
use Little\HTTP\Request;

ini_set('display_errors', '1');

require __DIR__ . '/../vendor/autoload.php';

$request = new Request($_SERVER['REQUEST_URI'],$_SERVER['REQUEST_METHOD'],$_POST);
$app = new Application();
return $app->handle($request)->send();
