<?php

namespace Little\Migrations;

use PDO;

class CreateLinksTable
{
    protected PDO $pdo;

    public function __construct()
    {
        $dbConnection = require 'config/db.config.php';
        $this->pdo = new PDO(
            $dbConnection['production']['dsn'],
            $dbConnection['production']['user'],
            $dbConnection['production']['password']
        );
    }

    public function up()
    {
//        $this->pdo->query('')
    }

    public function down(){

    }

}