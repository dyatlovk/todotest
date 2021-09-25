<?php

declare(strict_types=1);

namespace App\System;

use PDO;
use PDOException;

class Dbase
{
    public function connect(): PDO
    {
        /** @var Kernel $app */
        $app = $GLOBALS['kernel'];
        $connConfig = $app->getDbConfig();
        try {
            $dsn = $this->constructPdoDsn([
                'host' => $connConfig['host'],
                'port' => $connConfig['port'],
                'dbname' => $connConfig['dbname'],
            ]);
            $pdo = new PDO($dsn, $connConfig['user'], $connConfig['pass']);
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
