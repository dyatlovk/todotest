<?php

declare(strict_types=1);

namespace App\System;

use PDO;
use PDOException;

class Dbase
{
    private array $connParams;

    public function __construct(array $connParams)
    {
        $this->connParams = $connParams;
    }

    public function connect(): PDO
    {
        try {
            $dsn = $this->constructPdoDsn([
                'host' => $this->connParams['host'],
                'port' => $this->connParams['port'],
                'dbname' => $this->connParams['dbname'],
            ]);
            $pdo = new PDO($dsn, $this->connParams['user'], $this->connParams['pass']);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $pdo;
    }

    protected function constructPdoDsn(array $params)
    {
        $dsn = 'mysql:';
        if (isset($params['host']) && '' !== $params['host']) {
            $dsn .= 'host=' . $params['host'] . ';';
        }

        if (isset($params['port'])) {
            $dsn .= 'port=' . $params['port'] . ';';
        }

        if (isset($params['dbname'])) {
            $dsn .= 'dbname=' . $params['dbname'] . ';';
        }

        if (isset($params['unix_socket'])) {
            $dsn .= 'unix_socket=' . $params['unix_socket'] . ';';
        }

        if (isset($params['charset'])) {
            $dsn .= 'charset=' . $params['charset'] . ';';
        }

        return $dsn;
    }
}
