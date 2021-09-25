<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Tasks;
use App\Sanitizer\TaskSanitize;
use App\System\Templates;
use App\Validator\TaskValidator;

class TasksController
{
    private const FORM_NAME = 'task';

    public function add(): void
    {
        $formErrors = $_SESSION[self::FORM_NAME]['errors'];
        $previousData = $_SESSION[self::FORM_NAME]['data'];
        $_SESSION[self::FORM_NAME]['errors'] = null;
        $_SESSION[self::FORM_NAME]['data'] = null;
        $taskModel = new Tasks();
        $statuses = $taskModel->getStatusesList(null);

        echo (new Templates())->render('tasks/create.php', [
            'formName' => self::FORM_NAME,
            'formErrors' => $formErrors,
            'statuses' => $statuses,
            'formData' => $previousData,
        ]);
    }

    public function edit(array $routerArgs): void
    {
        $taskId = (int) $routerArgs[0];
        $taskModel = new Tasks();
        $task = $taskModel->findSingle($taskId);
        if (empty($task)) {
            header('HTTP/1.0 404 Not Found');

            return;
        }
        $formErrors = $_SESSION[self::FORM_NAME]['errors'];
        $_SESSION[self::FORM_NAME]['errors'] = null;
        $currentStatusId = (int) $task['task_status'];
        $statuses = $taskModel->getStatusesList($currentStatusId);
        echo (new Templates())->render('tasks/edit.php', [
            'task' => $task,
            'statuses' => $statuses,
            'formName' => self::FORM_NAME,
            'formErrors' => $formErrors,
        ]);
    }

    public function show(array $routerArgs): void
    {
        $taskId = (int) $routerArgs[0];
        $taskModel = new Tasks();
        $task = $taskModel->findSingle($taskId);
        if (empty($task)) {
            header('HTTP/1.0 404 Not Found');

            return;
        }
        echo (new Templates())->render('tasks/show.php', [
            'task' => $task,
        ]);
    }

    public function create(): void
    {
        $formData = $_POST[self::FORM_NAME];
        $formValidator = new TaskValidator();
        $formValidator->validateData($formData);
        if ($formValidator->hasErrors()) {
            $_SESSION[self::FORM_NAME]['errors'] = $formValidator->getErrors();
            $_SESSION[self::FORM_NAME]['data'] = $formData;
            header('Location: /task/add');

            return;
        }
        $taskModel = new Tasks();
        $dataSanitizer = new TaskSanitize();
        $cleanedData = $dataSanitizer->prepare($formData)->getCleaned();
        $result = $taskModel->create($cleanedData);
        if (false == $result) {
            return;
        }

        header('Location: /');
    }

    public function update(array $routerArgs): void
    {
        $taskId = (int) $routerArgs[0];
        $taskModel = new Tasks();
        $formData = $_POST[self::FORM_NAME];
        $formValidator = new TaskValidator();
        $formValidator->validateData($formData);
        if ($formValidator->hasErrors()) {
            $_SESSION[self::FORM_NAME]['errors'] = $formValidator->getErrors();
            header('Location: /task/' . $taskId . '/edit');

            return;
        }
        $formData = array_merge($formData, ['id' => $taskId]);
        $dataSanitizer = new TaskSanitize();
        $cleanedData = $dataSanitizer->prepare($formData)->getCleaned();
        $result = $taskModel->update($cleanedData);
        if (false == $result) {
            return;
        }

        header('Location: /');
    }

    public function delete(array $routerArgs): void
    {
        $taskId = (int) $routerArgs[0];
        $taskModel = new Tasks();
        $task = $taskModel->findSingle($taskId);
        if (empty($task)) {
            header('HTTP/1.0 404 Not Found');

            return;
        }
        $result = $taskModel->delete($taskId);
        if (false == $result) {
            return;
        }

        header('Location: /');
    }
}
