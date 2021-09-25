<?php

declare(strict_types=1);

namespace App\System;

class Kernel
{
    private array $db;

    public function boot(): void
    {
        $this->loadConfig();
        $this->loadRouters();
    }

    public static function getRootDir(): string
    {
        return __DIR__ . '/../../';
    }

    public function getDbConnection(): \PDO
    {
        $db = new Dbase($this->db);
        $conn = $db->connect();

        return $conn;
    }

    private function loadConfig(): void
    {
        $root = self::getRootDir();
        $db = require_once $root . '/config/dbase.php';
        $this->db = $db;
    }

    private function loadRouters(): void
    {
        $root = self::getRootDir();
        require_once $root . '/config/routers.php';
    }
}
