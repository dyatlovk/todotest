<?php

declare(strict_types=1);

namespace App\Controller;

use App\System\Templates;

class TasksController
{
    public function edit(): void
    {
        echo (new Templates())->render('tasks/edit.php');
    }

    public function show():void
    {
        echo (new Templates())->render('tasks/show.php');
    }
}
