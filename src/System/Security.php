<?php

declare(strict_types=1);

namespace App\System;

use App\Model\User;

class Security
{
    public function isGranted(string $userEmail): bool
    {
        $userModel = new User();
        $user = $userModel->loadFromSession();
        $email = $user['user_email'];
        if ($email === $userEmail) {
            return true;
        }

        return false;
    }
}
