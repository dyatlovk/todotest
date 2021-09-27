<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\User;
use App\System\Templates;

class BaseController
{
    public function denyAnon(): void
    {
        $userModel = new User();
        $user = $userModel->isLogged();
        if (false == $user) {
            $this->createAccessDenied();
        }
    }

    /**
     * @param array<string|int> $task
     */
    public function accessOwnerOrAdmin(array $task = []): void
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
        echo $this->render('errors/404.php');
        exit();
    }

    public function createAccessDenied(): void
    {
        header('HTTP/1.0 403 Forbidden');
        echo $this->render('errors/403.php');
        exit();
    }

    /**
     * @return array<string|int>
     */
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

    /**
     * @param array<string, mixed> $vars
     */
    public function render(?string $tpl, array $vars = []): string
    {
        return (new Templates())->render($tpl, $vars);
    }

    public function isEqual(?string $a, ?string $b): bool
    {
        if (is_null($a) && is_null($b)) {
            return false;
        }
        $hashA = hash('sha256', $a);
        $hashB = hash('sha256', $b);
        if (false == $hashA) {
            $hashA = '';
        }

        if (false == $hashB) {
            $hashB = '';
        }

        return $hashA !== $hashB;
    }

    public function whoModified(string $oldText, string $newText, ?string $modified = null): ?int
    {
        $userModel = new User();
        $adminuser = $userModel->findByEmail(User::ADMIN_EMAIL);
        if (!is_null($modified)) {
            $modified = (int) $modified;
        }
        $isTextModified = $this->isEqual($oldText, $newText);
        if ($isTextModified && $this->isUserAdmin()) {
            $modified = (int) $adminuser['user_id'];
        }

        return $modified;
    }
}
