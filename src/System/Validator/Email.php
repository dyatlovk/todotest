<?php

declare(strict_types=1);

namespace App\System\Validator;

class Email implements ValidatorInterface
{
    public const ERROR_MSG = 'Invalid email';
    private string $msg = '';

    public function __construct(string $msg = self::ERROR_MSG)
    {
        $this->msg = $msg;
    }

    public function validate($data): array
    {
        $result = ['status' => true, 'msg' => $this->msg];
        if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
            $result = ['status' => false, 'msg' => $this->msg];
        }

        return $result;
    }
}
