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

    public function up(): void
    {
        $stmt = $this->pdo->query('
            CREATE TABLE IF NOT EXISTS `links` (
              `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
              `base_link` varchar(1024)  NOT NULL,
              `short_link` varchar(255)  NOT NULL
            )
        ');
        if ($stmt->execute()) {
            echo 'table links created', PHP_EOL;
        }
    }

    public function down(): void
    {
        $stmt = $this->pdo->query('DROP TABLE IF EXISTS links');
        if ($stmt->execute()) {
            echo 'table links deleted', PHP_EOL;
        }
    }

}