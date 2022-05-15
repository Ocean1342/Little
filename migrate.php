<?php


use Little\Migrations\CreateLinksTable;

require 'vendor/autoload.php';

$migration = new CreateLinksTable();
$method = $argv[1];
$migration->$method();