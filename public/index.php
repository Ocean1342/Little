<?php

use Little\Application;

ini_set('display_errors', '1');

require __DIR__ . '/../vendor/autoload.php';

$app = new Application();
return $app->handle()->send();
