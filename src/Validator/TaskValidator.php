<?php

declare(strict_types=1);

namespace App\Validator;

class TaskValidator
{
    /** @var array<string, array<string>> */
    private ?array $errors = null;

    /**
     * @param array<string, array<string|int>> $data
     */
    public function validateData(array $data): void
    {
        if (empty($data)) {
            $this->errors['form'] = 'Empty data does not allow';
        }
        if (empty($data['text'])) {
            $this->errors['children']['text'] = 'Empty text does not allow';
        }
        if (empty($data['email'])) {
            $this->errors['children']['email'] = 'Empty email does not allow';
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['children']['email'] = 'Email address is invalid.';
        }
        if (empty($data['username'])) {
            $this->errors['children']['username'] = 'Empty username does not allow';
        }
        if (empty($data['status'])) {
            $this->errors['children']['status'] = 'Empty status does not allow';
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
