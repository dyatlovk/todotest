<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\User;

class BaseController
{
    public function denyAnon(): void
    {
        $userModel = new User();
        $user = $userModel->isLogged();
        if (false == $user) {
            header('HTTP/1.0 403 Forbidden');
            exit();
        }
    }

    public function allowOwnerOrAdmin(array $task = []): void
    {
        $userModel = new User();
        $isAnon = !$userModel->isLogged();
        if ($isAnon) {
            $this->createAccessDenied();
        }
        $isAdmin = $userModel->isAdmin();
        if ($isAdmin) {
            return;
        }
        $isOwner = $userModel->isTaskOwner((int) $task['task_owner']);
        if ($isOwner) {
            return;
        }
        $this->createAccessDenied();
    }

    public function createNotFound(): void
    {
        header('HTTP/1.0 404 Not Found');
        exit();
    }

    public function createAccessDenied(): void
    {
        header('HTTP/1.0 403 Forbidden');
        exit();
    }

    public function getUser(): array
    {
        $userModel = new User();
        $user = $userModel->loadFromSession();
        if (is_null($user)) {
            return [];
        }

        return $user;
    }

    public function isUserAdmin(): bool
    {
        $userModel = new User();

        return $userModel->isAdmin();
    }
}
