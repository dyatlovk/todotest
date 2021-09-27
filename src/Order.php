<?php

declare(strict_types=1);

namespace App;

use App\Model\Tasks;
use App\Model\User;

class Order
{
    private string $keyDir;
    private string $keyField;
    private string $fieldValue;
    private string $dirValue;

    public function __construct(string $fieldKey = 'sort', string $dirKey = 'dir')
    {
        $this->keyDir = $dirKey;
        $this->keyField = $fieldKey;
        $this->valuesFromGlobal();
    }

    public function prepareSql(): string
    {
        $userAlias = User::COL_ALIAS;
        $taskAlias = Tasks::COL_ALIAS;
        $orderExpr = "$taskAlias.id DESC";
        if (!in_array($this->fieldValue, Tasks::ORDER_FIELDS)) {
            return $orderExpr;
        }
        if ('username' === $this->fieldValue) {
            $orderExpr = "$userAlias.username " . $this->dirValue;
        }
        if ('email' === $this->fieldValue) {
            $orderExpr = "$userAlias.email " . $this->dirValue;
        }
        if ('status' === $this->fieldValue) {
            $orderExpr = "$taskAlias.status " . $this->dirValue;
        }

        return $orderExpr;
    }

    /**
     * @return array<string>
     */
    public function buildQuery(): array
    {
        $dir = $this->toggleDirection();
        $request = $_REQUEST;
        unset($request[$this->keyDir]);
        unset($request[$this->keyField]);
        $prevQuery = '';
        if (false == empty($request)) {
            $prevQuery = '&' . http_build_query($request);
        }
        $dirQuery = '&' . $this->keyDir . '=' . $dir;

        $result = [];
        foreach (Tasks::ORDER_FIELDS as $field) {
            $result[$field] = '?' . $this->keyField . '=' . $field . $dirQuery . $prevQuery;
        }

        return $result;
    }

    public function toggleDirection(): string
    {
        if (empty($this->dirValue)) {
            return 'asc';
        }

        return ('asc' === $this->dirValue) ? 'desc' : 'asc';
    }

    private function valuesFromGlobal(): void
    {
        $this->fieldValue = (string) $_REQUEST[$this->keyField];
        $this->dirValue = (string) $_REQUEST[$this->keyDir];
    }
}
