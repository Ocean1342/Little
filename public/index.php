<?php

use Little\Application;
use Symfony\Component\HttpFoundation\Request;

ini_set('display_errors', '1');

require __DIR__ . '/../vendor/autoload.php';

$app = new Application();
return $app->handle(Request::createFromGlobals())->send();