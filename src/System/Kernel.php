<?php

declare(strict_types=1);

namespace App\System;

class Kernel
{
    public const SESSION_TTL = 3600 * 24;
    public const NAME = 'kernel';

    /** @var array<string> */
    private array $db = [];

    public function boot(): void
    {
        $this->startSession();
        $this->loadDbConfig();
        $this->loadRouters();
    }

    public static function getRootDir(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . '/../';
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

    private function loadDbConfig(): void
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

    private function startSession(): void
    {
        session_set_cookie_params(self::SESSION_TTL, '/', '', true, true);
        session_start();
    }
}
