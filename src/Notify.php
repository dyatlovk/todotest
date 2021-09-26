<?php

declare(strict_types=1);

namespace App;

class Notify
{
    private const SESSION_KEY = 'notifymsg';

    public static function send(?string $msg): void
    {
        $_SESSION[self::SESSION_KEY] = (string) $msg;
    }

    public static function catch(): string
    {
        $msg = $_SESSION[self::SESSION_KEY];
        $_SESSION[self::SESSION_KEY] = null;

        return (string) $msg;
    }
}
