<?php

declare(strict_types=1);

namespace App\Sanitizer;

class TaskSanitize
{
    /**
     * @var array<string|mixed>
     */
    public array $cleanedData;

    /**
     * @param array<string|mixed> $formData
     */
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

    /**
     * @return array<string|mixed>
     */
    public function getCleaned(): array
    {
        return $this->cleanedData;
    }
}
