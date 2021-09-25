<?php

declare(strict_types=1);

namespace App\Sanitizer;

class TaskSanitize
{
    public array $cleanedData;

    public function prepare(array $formData): self
    {
        if (isset($formData['title'])) {
            $this->cleanedData['title'] = htmlspecialchars($formData['title']);
        }
        if (isset($formData['text'])) {
            $this->cleanedData['text'] = htmlspecialchars($formData['text']);
        }
        if (isset($formData['status'])) {
            $this->cleanedData['status'] = htmlspecialchars($formData['status']);
        }
        if (isset($formData['id'])) {
            $this->cleanedData['id'] = (int) $formData['id'];
        }

        return $this;
    }

    public function getCleaned(): array
    {
        return $this->cleanedData;
    }
}
