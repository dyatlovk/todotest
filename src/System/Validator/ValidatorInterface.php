<?php

declare(strict_types=1);

namespace App\System\Validator;

interface ValidatorInterface
{
    public function validate($data): array;
}
