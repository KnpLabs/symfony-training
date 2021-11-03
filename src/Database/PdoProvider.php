<?php

namespace App\Database;

use PDO;

class PdoProvider 
{
    private ?PDO $pdo = null;

    public function __construct(
        private string $host,
        private string $dbName,
        private string $user,
        private string $password
    ) {}

    public function getPdo(): PDO
    {
        if ($this->pdo === null) {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbName}",
                $this->user, 
                $this->password
            );
        }

        return $this->pdo;
    }
}
