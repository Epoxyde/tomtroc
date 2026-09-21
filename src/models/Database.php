<?php

class Database
{
    private PDO $connection;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/config.php';
        $dbConfig = $config['db'];

        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            $dbConfig['host'],
            $dbConfig['port'],
            $dbConfig['dbname'],
            $dbConfig['charset']
        );

        $this->connection = new PDO(
            $dsn,
            $dbConfig['user'],
            $dbConfig['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}