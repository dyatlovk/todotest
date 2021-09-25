<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Tasks;
use App\System\Templates;

class TasksController
{
    public function edit(array $routerArgs): void
    {
        $taskId = (int) $routerArgs[0];
        $taskModel = new Tasks();
        $task = $taskModel->findById($taskId);
        $statuses = $taskModel->getStatusesList((int) $task['task_status']);
        if (empty($task)) {
            header('HTTP/1.0 404 Not Found');

            return;
        }
        echo (new Templates())->render('tasks/edit.php', [
            'task' => $task,
            'statuses' => $statuses,
        ]);
    }

    public function show(array $routerArgs): void
    {
        $taskId = (int) $routerArgs[0];
        $taskModel = new Tasks();
        $task = $taskModel->findById($taskId);
        if (empty($task)) {
            header('HTTP/1.0 404 Not Found');

            return;
        }
        echo (new Templates())->render('tasks/show.php', [
            'task' => $task,
        ]);
    }

    private function routerArgsIsExists(array $args = []): void
    {
        if (!isset($args[0])) {
            header('HTTP/1.0 404 Not Found');

            return;
        }
    }
}
