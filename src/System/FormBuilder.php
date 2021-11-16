<?php

declare(strict_types=1);

namespace App\System;

use Exception;

class FormBuilder
{
    public const TYPE_TEXT = 'text';
    public const TYPE_EMAIL = 'email';
    public const TYPE_TEXTAREA = 'textarea';
    public const TYPE_RADIO = 'radio';
    public const TYPE_CHECKBOX = 'checkbox';
    public const TYPE_HIDDEN = 'hidden';
    public const TYPE_SELECT = 'select';

    private array $fields = [];
    private array $formAttr = [];
    private string $formName = '';
    private array $errors = [];

    public function __construct(
        ?string $name = null,
        array $attr = []
    ) {
        if (is_null($name)) {
            throw new Exception('form name required');
        }
        $this->formName = $name;
        $this->formAttr = $attr;
    }

    public function add(string $name, string $type, array $attr = [], array $constraints = [])
    {
        $this->fields[] = [
            'name' => $name,
            'type' => $type,
            'attr' => $attr,
            'constraints' => $constraints,
        ];

        /* return $this; */
    }

    public function addError(string $name, string $msg): self
    {
        $field = $this->getField($name);
        if ($field) {
            $this->errors[$name][] = $msg;
        }
        return $this;
    }

    public function getError(string $name): array
    {
        if (false == isset($this->errors[$name])) {
            return [];
        }

        return $this->errors[$name];
    }

    public function getField(string $name): ?array
    {
        $found = null;
        foreach ($this->fields as $field) {
            if ($field['name'] === $name) {
                $found = $field;
                break;
            }
        }

        return $found;
    }

    public function fieldSetData(string $fieldName, $data): void
    {
        foreach ($this->fields as $id => $field) {
            if ($field['name'] === $fieldName) {
                $this->fields[$id]['attr']['value'] = $data;
            }
        }
    }

    public function start(): void
    {
        echo '<form method="' . $this->formAttr['method'] . '" name="' . $this->formName . '" action="' . $this->formAttr['action'] . '" novalidate>';
    }

    public function end(): void
    {
        echo '</form>';
    }

    public function renderField(string $name, string $class = ''): void
    {
        $field = $this->getField($name);
        if (is_null($field)) {
            return;
        }
        $inputName = $this->formName . '[' . $field['name'] . ']';
        $id = $this->formName . '_' . $field['name'];
        $errorField = $this->getError($name);

        if ($field['type'] === self::TYPE_TEXT) {
            echo '<input id="' . $id . '" type="text" class="' . $class . (empty($errorField) ? '' : ' is-invalid') . '" name="' . $inputName . '" value="' . $field['attr']['value'] . '">';
        }

        if ($field['type'] === self::TYPE_HIDDEN) {
            echo '<input id="' . $id . '" type="hidden" class="' . $class . (empty($errorField) ? '' : ' is-invalid') . '" name="' . $inputName . '" value="' . $field['attr']['value'] . '">';
        }

        if ($field['type'] === self::TYPE_EMAIL) {
            echo '<input id="' . $id . '" type="email" class="' . $class . (empty($errorField) ? '' : ' is-invalid') . '" name="' . $inputName . '" value="' . $field['attr']['value'] . '">';
        }

        if ($field['type'] === self::TYPE_RADIO) {
            $checked = $field['attr']['value'];
            $radioCount = 0;
            foreach ($field['attr']['choices'] as $label => $val) {
                echo '<div class="form-check">';
                echo '<input id="' . $id . '_' . $radioCount . '" type="radio" class="' . $class . (empty($errorField) ? '' : ' is-invalid') . '" name="' . $inputName . '" value="' . $val . '" ' . ($checked == $val ? "checked" : "") . '>';
                echo '<label for="' . $id . '_' . $radioCount . '" class="form-check-label">' . $label . '</label>';
                echo '</div>';
                ++$radioCount;
            }
        }

        if ($field['type'] === self::TYPE_TEXTAREA) {
            echo '<textarea id="' . $id . '" class="' . $class . (empty($errorField) ? '' : ' is-invalid') . '" name="' . $inputName . '">' . $field['attr']['value'] . '</textarea>';
        }

        if ($field['type'] === self::TYPE_CHECKBOX) {
            $checkCount = 0;
            $values = $field['attr']['value'];
            $checked = false;
            foreach ($field['attr']['choices'] as $label => $val) {
                if (in_array($val, $values)) {
                    $checked = true;
                }
                echo '<div class="form-check">';
                echo '<input id="' . $id . '_' . $checkCount . '" type="checkbox" class="' . $class . (empty($errorField) ? '' : ' is-invalid') . '" name="' . $inputName . '[]" value="' . $val . '" ' . ($checked ? "checked" : "") . '>';
                echo '<label for="' . $id . '_' . $checkCount . '" class="form-check-label">' . $label . '</label>';
                echo '</div>';
                $checked = false;
                ++$checkCount;
            }
        }

        if ($field['type'] === self::TYPE_SELECT) {
            $checkCount = 0;
            $values = $field['attr']['value'];
            $checked = false;
            echo '<select name="' . $inputName . '[]" class="form-select">';
            foreach ($field['attr']['choices'] as $label => $val) {
                if (in_array($val, $values)) {
                    $checked = true;
                }
                echo '<option value="' . $val . '" ' . ($checked ? "selected" : "") . '>' . $label . '</option>';
                $checked = false;
                ++$checkCount;
            }
            echo '</select>';
        }
    }

    public function renderLabel(string $name)
    {
        $field = $this->getField($name);
        $id = $this->formName . '_' . $field['name'];
        echo '<div>' . $field['name'] . '</div>';
    }

    public function renderError(string $name): void
    {
        $errors = $this->getError($name);
        foreach ($errors as $msg) {
            echo '<div class="invalid-feedback">' . $msg . '</div>';
        }
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function isSubmit(): bool
    {
        if (isset($_POST[$this->formName])) {
            return true;
        }

        return false;
    }

    public function getRawData(): array
    {
        if (false == $this->isSubmit()) {
            throw new Exception('form must be submit');
        }

        return $_POST[$this->formName];
    }

    public function isValid(): bool
    {
        $this->fillData();
        $errorsCount = 0;
        $fields = $this->getFields();
        foreach ($fields as $field) {
            $constraints = $field['constraints'];
            foreach ($constraints as $constraint) {
                if (false == empty($constraint)) {
                    $fieldIsValid = $constraint->validate($field['attr']['value']);
                    if (false == $fieldIsValid['status']) {
                        $this->addError($field['name'], $fieldIsValid['msg']);
                        ++$errorsCount;
                    }
                }
            }
        }
        if ($errorsCount > 0) {
            return false;
        }
        return true;
    }

    public function getName(): string
    {
        return $this->formName;
    }

    public function generateCSRFToken(): string
    {
        $token = '';
        if (false == isset($_SESSION[$this->formName . '_token'])) {
            $token = bin2hex(random_bytes(32));
            $_SESSION[$this->formName . '_token'] = $token;
        }

        if (true == isset($_SESSION[$this->formName . '_token'])) {
            $token = $_SESSION[$this->formName . '_token'];
        }

        return $token;
    }

    private function fillData(): void
    {
        $raw = $this->getRawData();
        foreach ($raw as $name => $data) {
            $this->fieldSetData($name, $data);
        }
    }
}
