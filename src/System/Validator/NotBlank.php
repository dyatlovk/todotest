<?php

declare(strict_types=1);

namespace App\System\Validator;

class NotBlank implements ValidatorInterface
{
    public const ERROR_MSG = 'Empty field';
    private string $msg = '';

    public function __construct(string $msg = self::ERROR_MSG)
    {
        $this->msg = $msg;
    }
    public function validate($data): array
    {
        $result = ['status' => true, 'msg' => $this->msg];
        if (empty($data)) {
            $result = ['status' => false, 'msg' => $this->msg];
        }

        return $result;
    }
}
