<?php

declare(strict_types=1);

namespace App\Controller;

use App\System\Templates;

class HomepageController
{
    public function index(): void
    {
        echo (new Templates())->render('home/index.php', [
            'var' => 'test',
        ]);
    }

    public function test(): void
    {
        echo (new Templates())->render('home/test.php');
    }

    public function blog(...$args): void
    {
        echo 'blog';
    }
}
