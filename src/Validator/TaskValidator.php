<?php

declare(strict_types=1);

namespace App\Validator;

class TaskValidator implements ValidatorInterface
{
    private ?array $errors = null;

    public function validateData(array $data): void
    {
        if (empty($data)) {
            $this->errors['form'] = 'Empty data does not allow';
        }
        if (empty($data['title'])) {
            $this->errors['children']['title'] = 'Empty title does not allow';
        }
        if (empty($data['text'])) {
            $this->errors['children']['text'] = 'Empty text does not allow';
        }
        if (empty($data['status'])) {
            $this->errors['children']['status'] = 'Empty status does not allow';
        }
    }

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
