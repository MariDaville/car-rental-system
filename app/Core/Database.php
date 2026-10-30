<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    /**
     * Establish or retrieve the database connection.
     */
    public static function getConnection(): PDO
    {
        if (self::$connection === null) {

            $config = require BASE_PATH . '/config/database.php';

            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                $config['host'],
                $config['port'],
                $config['database'],
                $config['charset']
            );

            try {

                self::$connection = new PDO(
                    $dsn,
                    $config['username'],
                    $config['password'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

                        PDO::ATTR_EMULATE_PREPARES => false
                    ]
                );

            } catch (PDOException $e) {

                error_log(
                    'Database connection error: ' . $e->getMessage()
                );

                throw new \RuntimeException(
                    'Unable to connect to the database.'
                );
            }
        }

        return self::$connection;
    }
}