<?php

declare(strict_types=1);

namespace App\System;

class Kernel
{
    public const NAME = 'kernel';

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

    public static function getInstance(): self
    {
        /** @var Kernel $app */
        $app = $GLOBALS[Kernel::NAME];

        return $app;
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
