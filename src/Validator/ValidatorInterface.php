<?php

declare(strict_types=1);

namespace App\Validator;

interface ValidatorInterface
{
    public function validateData(array $data): void;

    public function getErrors(): ?array;

    public function hasErrors(): bool;
}
