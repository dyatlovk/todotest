<?php

declare(strict_types=1);

namespace App\Controller;

use App\Forms\TestForm;
use App\System\Router;
use App\System\Templates;

class HomepageController
{
    public function index(): string
    {
        $form = (new TestForm())->build();
        if ($form->isSubmit() && $form->isValid()) {
        }
        return (new Templates())->render('home/index.php', [
            'form' => $form,
        ]);
    }

    public function test(): string
    {
        return (new Templates())->render('home/test.php');
    }

    public function testEntry(): string
    {
        return 'test entry';
    }
}
