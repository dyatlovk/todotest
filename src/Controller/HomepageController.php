<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Task;
use App\System\Templates;

class HomepageController
{
    public function index(): void
    {
        $taskModel = new Task();
        $list = $taskModel->getAll();
        echo (new Templates())->render('home/index.php', [
            'taskList' => $list,
        ]);
    }
}
