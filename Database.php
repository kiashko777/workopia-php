<?php

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
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
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

    public function query(string $query): PDOStatement
    {
        try {
            return $this->conn->query($query);
        } catch (PDOException $e) {
            throw new \RuntimeException ("Query failed to execute: {$e->getMessage()}");
        }
    }


}