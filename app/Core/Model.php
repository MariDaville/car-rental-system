<?php

namespace App\Core;

use PDO;

class Model
{
    protected PDO $db;

    /**
     * Initialize database connection.
     */
    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Execute a SQL query.
     */
    protected function query(
        string $sql,
        array $params = []
    ): \PDOStatement {

        $statement = $this->db->prepare($sql);

        $statement->execute($params);

        return $statement;
    }

    /**
     * Retrieve a single record.
     */
    protected function find(string $sql, array $params = []): ?array
    {
        $result = $this->query($sql, $params)->fetch();

        return $result ?: null;
    }

    /**
     * Retrieve multiple records.
     */
    protected function findAll(
        string $sql,
        array $params = []
    ): array {

        return $this->query($sql, $params)->fetchAll();
    }

    /**
     * Insert, update or delete records.
     */
    protected function execute(
        string $sql,
        array $params = []
    ): int {

        return $this->query($sql, $params)->rowCount();
    }
}