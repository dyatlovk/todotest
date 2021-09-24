<?php

declare(strict_types=1);

namespace App\System;

class Kernel
{
    public function boot(): void
    {
        echo "booted";
    }

    public static function getRootDir(): string
    {
        return __DIR__ . '/../../';
    }
}
