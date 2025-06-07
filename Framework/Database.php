<?php

// This is the database class.

namespace Framework;

use Exception;
use PDO;
use PDOException;
use PDOStatement;

class Database
{
    public PDO $conn;

    /**
     *Constructor for Database class
     *
     * @param array $config
     * @throws Exception
     */

    public function __construct(array $config)
    {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";
        $options = [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ];

        try {
            $this->conn = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (PDOException $e) {
            throw new \RuntimeException("Database connection failed: {$e->getMessage()}");
        }
    }

    /**
     *Query the database
     *
     * @param string $query
     * @return PDOStatement
     * @throws PDOException
     * @throws Exception
     */

    public function query(string $query, array $params = []): PDOStatement
    {
        try {
            $sth = $this->conn->prepare($query);
            //Bind named parameters
            foreach ($params as $param => $value) {
                $sth->bindValue(':' . $param, $value);
            }
            $sth->execute();
            return $sth;

        } catch (PDOException $e) {
            throw new \RuntimeException("Query failed to execute: " .
              $e->getMessage());
        }
    }
}