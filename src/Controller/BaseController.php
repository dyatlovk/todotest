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

    public function createNotFound(): void
    {
        header('HTTP/1.0 404 Not Found');
        exit();
    }
}
