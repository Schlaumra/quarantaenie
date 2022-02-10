<?php

namespace inc\db;

use Generator;
use PDO;
use PDOException;

class DB
{
    protected PDO $PDO;
    protected string $dsn;

    public function __construct(string $dbName,
                                string $username = NULL,
                                string $password = NULL,
                                string $host = 'localhost',
                                int    $port = 3307)
    {
        $this->dsn = "mysql:host=$host;port=$port;dbname=$dbName";
        $this->PDO = new PDO($this->dsn, $username, $password);
    }

    /**
     * Query the database.
     *
     * @param string $query => The query with optional placeholders
     * @param array $params => The parameters for the placeholders
     * @param bool $throwIfBindingFails => If there is a parameter too much or wrong it will throw an error
     * @return Generator A Generator iterating through the rows of the result
     */
    public function query(string $query, array $params = [], bool $throwIfBindingFails = true): Generator
    {
        $pdoQuery = $this->PDO->prepare($query);
        foreach ($params as $param => $value)
        {
            if(!$pdoQuery->bindValue($param, $value) and $throwIfBindingFails)
            {
                throw new PDOException('Failed to bind value.');
            }
        }
        $pdoQuery->execute();
        foreach ($pdoQuery as $item) {
            yield $item;
        }
    }
}