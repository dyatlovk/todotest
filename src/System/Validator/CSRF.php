<?php

declare(strict_types=1);

namespace App\System\Validator;

class CSRF implements ValidatorInterface
{
    public const ERROR_MSG = 'Invalid csrf token';
    private string $msg = '';
    private string $formName = '';

    public function __construct(string $formName = '', string $msg = self::ERROR_MSG)
    {
        $this->msg = $msg;
        $this->formName = $formName;
    }

    public function validate($data): array
    {
        $result = ['status' => false, 'msg' => $this->msg];

        $tokenRequest = $_POST[$this->formName]['token'];
        $tokenInSession = $_SESSION[$this->formName . '_token'];
        if ($tokenInSession === $tokenRequest) {
            $result = ['status' => true, 'msg' => $this->msg];
        }

        return $result;
    }
}
