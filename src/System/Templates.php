<?php

declare(strict_types=1);

namespace App\System;

use Exception;

class Templates
{
    private const PATH = 'templates/';

    public array $blocks;

    public function extend(?string $path): void
    {
        if (is_null($path)) {
            return;
        }

        ob_end_clean();
        ob_start();
        echo $this->render($path);
    }

    public function start()
    {
        ob_start();
    }

    public function end(string $name): void
    {
        $buffer = ob_get_clean();

        if (!isset($this->blocks[$name])) {
            $this->blocks[$name] = $buffer;
        }
        echo $this->blocks[$name];
    }

    public function block(string $name): ?string
    {
        if (isset($this->blocks[$name])) {
            return $this->blocks[$name];
        }

        return null;
    }

    public function render(?string $file, array $args = []): string
    {
        if (is_null($file)) {
            return '';
        }
        $rootDir = Kernel::getRootDir();
        $file = $rootDir . self::PATH . $file;
        if (!file_exists($file)) {
            throw new Exception('template not found');
        }
        extract($args);

        ob_start();
        require $file;
        $content = ob_get_clean();

        return (string) $content;
    }
}
