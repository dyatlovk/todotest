<?php

declare(strict_types=1);

namespace App\Validator;

class UserValidator
{
    /** @var array<string, array<string>> */
    private ?array $errors = null;

    /**
     * @param array<string> $data
     */
    public function validateData(array $data): void
    {
        if (empty($data['username'])) {
            $this->errors['children']['username'] = 'Empty name does not allow';
        }
        if (empty($data['password'])) {
            $this->errors['children']['password'] = 'Empty password does not allow';
        }
    }

    /**
     * @return array<string, array<string>>
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        if (count($this->errors) > 0) {
            return true;
        }

        return false;
    }
}
