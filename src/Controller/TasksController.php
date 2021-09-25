<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Task;
use App\System\Templates;

class TasksController
{
    public function edit(): void
    {
        echo (new Templates())->render('tasks/edit.php');
    }

    public function show(array $routerArgs): void
    {
        if (!isset($routerArgs[0])) {
            header('HTTP/1.0 404 Not Found');

            return;
        }
        $taskId = (int) $routerArgs[0];
        $taskModel = new Task();
        $task = $taskModel->findById($taskId);
        if(empty($task)) {
            header('HTTP/1.0 404 Not Found');

            return;
        }
        echo (new Templates())->render('tasks/show.php', [
            'task' => $task,
        ]);
    }
}
