<?php

declare(strict_types=1);

namespace App\Sanitizer;

class TaskSanitize
{
    /**
     * @var array<string|mixed>
     */
    public array $cleanedData = [];

    /**
     * @param array<string|mixed> $formData
     */
    public function prepare(array $formData): self
    {
        if (isset($formData['username'])) {
            $this->cleanedData['username'] = htmlspecialchars($formData['username']);
        }
        if (isset($formData['email'])) {
            $sanitized_email = filter_var($formData['email'], FILTER_SANITIZE_EMAIL);
            if ($sanitized_email) {
                $this->cleanedData['email'] = htmlspecialchars($sanitized_email);
            }
            if(false == $sanitized_email) {
                $this->cleanedData['email'] = htmlspecialchars($formData['email']);
            }
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
