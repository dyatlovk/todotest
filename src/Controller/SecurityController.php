<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\User;
use App\System\Templates;
use App\Validator\UserValidator;

class SecurityController
{
    private const LOGIN_FORM_NAME = 'login';

    public function login(): void
    {
        $authError = $_SESSION['credentials_error'];
        $formErrors = $_SESSION[self::LOGIN_FORM_NAME]['errors'];
        $_SESSION['credentials_error'] = null;
        $_SESSION[self::LOGIN_FORM_NAME] = null;
        echo (new Templates())->render('security/login.php', [
            'formName' => self::LOGIN_FORM_NAME,
            'authError' => $authError,
            'formErrors' => $formErrors,
        ]);
    }

    public function check(): void
    {
        $formData = $_POST[self::LOGIN_FORM_NAME];
        $formValidator = new UserValidator();
        $formValidator->validateData($formData);
        if ($formValidator->hasErrors()) {
            $_SESSION[self::LOGIN_FORM_NAME]['errors'] = $formValidator->getErrors();
            header('Location: /login');

            return;
        }

        $userModel = new User();
        $isAuth = $userModel->authenticate($formData);
        if (!$isAuth) {
            $_SESSION['credentials_error'] = 'Bad credentials';
            header('Location: /login');

            return;
        }
        header('Location: /');
    }

    public function logout(): void
    {
        $_SESSION['user'] = null;
        header('Location: /');
    }
}
