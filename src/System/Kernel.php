<?php

declare(strict_types=1);

namespace App\System;

class Kernel
{
    public const SESSION_TTL = 3600 * 24;
    public const NAME = 'kernel';

    public const ENV_PROD = 'prod';
    public const ENV_DEV = 'dev';
    public const ENV = [
        self::ENV_DEV,
        self::ENV_PROD,
    ];

    /** @var array<string> */
    private array $db = [];
    private string $env = self::ENV_PROD;

    public function __construct(?string $env = self::ENV_PROD)
    {
        $this->env = $env;
        if ($env !== self::ENV_PROD) {
            ini_set('display_errors', '1');
        }
    }

    public function getEnv(): string
    {
        return $this->env;
    }

    public function boot(): void
    {
        $this->startSession();
        /* $this->loadDbConfig(); */
        $this->loadRouters();
        global ${Kernel::NAME};
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
        ini_set('session.name', 'SESSID');
        session_set_cookie_params(self::SESSION_TTL, '/', '', true, true);
        session_start();
    }
}
