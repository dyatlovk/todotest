<?php

declare(strict_types=1);

namespace App\Model;

use App\System\Kernel;
use PDO;

class Tasks
{
    public const COL_ALIAS = 't_';
    public const MAX_ITEMS = 10;
    public const ORDER_FIELDS = ['username', 'email', 'status'];

    public const STATUS_OPEN = 1;
    public const STATUS_CLOSE = 2;
    public const STATUS_COMPLETE = 3;
    public const STATUS_DEFAULT = self::STATUS_OPEN;
    public const STATUSES = [
        self::STATUS_CLOSE => 'Closed',
        self::STATUS_COMPLETE => 'Completed',
        self::STATUS_OPEN => 'Open',
    ];

    /**
     * @return array<string|mixed>
     */
    public function getAll(int $start = 0, int $limit = self::MAX_ITEMS, string $orderExpr): array
    {
        $taskAlias = self::COL_ALIAS;
        $userAlias = User::COL_ALIAS;
        $conn = $this->getConnection();
        $sql = "
            SELECT
                $taskAlias.id as task_id,
                $taskAlias.text as task_text,
                $taskAlias.status as task_status,
                $taskAlias.modified_by_id as modified_by,
                $userAlias.username as user_name,
                $userAlias.email as user_email
            FROM tasks $taskAlias
            INNER JOIN user $userAlias ON $userAlias.id = $taskAlias.owner_id
            ORDER BY $orderExpr
            LIMIT :limit OFFSET :offset";
        $query = $conn->prepare($sql);
        if (false == $query) {
            return [];
        }
        $query->bindValue(':limit', $limit, PDO::PARAM_INT);
        $query->bindValue(':offset', $start, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll();
        if (false == $result) {
            return [];
        }

        return $result;
    }

    /**
     * @return array<string|mixed>
     */
    public function findSingle(int $id): array
    {
        $alias = self::COL_ALIAS;
        $userAlias = User::COL_ALIAS;
        $conn = $this->getConnection();
        $sql = "
            SELECT
                $alias.id as task_id,
                $alias.text as task_text,
                $alias.status as task_status,
                $alias.owner_id as task_owner,
                $alias.modified_by_id as modified_admin,
                $userAlias.id as user_id,
                $userAlias.email as email,
                $userAlias.username as username
            FROM tasks $alias
            INNER JOIN user $userAlias ON $userAlias.id = $alias.owner_id
            WHERE $alias.id = :task_id";

        $query = $conn->prepare($sql);
        if (false == $query) {
            return [];
        }
        $query->bindValue(':task_id', $id, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch();
        if (false == $result) {
            return [];
        }

        return $result;
    }

    public function pages(int $itemsPerPage): int
    {
        $max = $this->findMaxItems();
        $pages = (int) ceil($max / $itemsPerPage);
        if (1 == $pages) {
            $pages = 0;
        }

        return $pages;
    }

    public function findMaxItems(): ?int
    {
        $alias = self::COL_ALIAS;
        $conn = $this->getConnection();
        $sql = "SELECT COUNT($alias.id) as count FROM tasks $alias";
        $query = $conn->query($sql);
        if (false == $query) {
            return null;
        }
        $result = $query->fetch();

        if (isset($result['count'])) {
            return (int) $result['count'];
        }

        return null;
    }

    /**
     * @return array<int, array<string|bool|int>>
     */
    public function getStatusesList(?int $actual): array
    {
        $map = self::STATUSES;
        $result = [];
        foreach ($map as $id => $item) {
            $result[$id]['isSelected'] = false;
            $result[$id]['value'] = $id;
            $result[$id]['name'] = $item;
            if ($actual == $id) {
                $result[$id]['isSelected'] = true;
            }
        }

        return $result;
    }

    /**
     * @param array<string, mixed> $data
     */
    public function create(array $data): bool
    {
        $userModel = new User();
        $user = $userModel->createIfNotExist($data['username'], $data['email']);
        $sql = '
            INSERT INTO tasks (text, status, owner_id)
            VALUES(:text, :status, :owner)';
        $conn = $this->getConnection();
        $query = $conn->prepare($sql);
        $status = (isset($data['status'])) ? (int) $data['status'] : self::STATUS_DEFAULT;
        $query->bindValue(':text', $data['text'], PDO::PARAM_STR);
        $query->bindValue(':status', $status, PDO::PARAM_INT);
        $query->bindValue(':owner', (int) $user['user_id'], PDO::PARAM_INT);

        return $query->execute();
    }

    /**
     * @param array<string|int> $data
     */
    public function update(array $data, ?int $modifyBy = null): bool
    {
        $alias = self::COL_ALIAS;
        $sql = "
            UPDATE tasks $alias SET
                $alias.text = :text,
                $alias.status = :status,
                $alias.modified_by_id = :modified_id
            WHERE $alias.id = :id
        ";
        $conn = $this->getConnection();
        $query = $conn->prepare($sql);
        $query->bindValue(':text', $data['text'], PDO::PARAM_STR);
        $query->bindValue(':status', $data['status'], PDO::PARAM_INT);
        $query->bindValue(':id', $data['id'], PDO::PARAM_INT);
        $query->bindValue(':modified_id', $modifyBy);

        return $query->execute();
    }

    public function delete(int $taskId): bool
    {
        $sql = 'DELETE FROM tasks WHERE id = :id';
        $conn = $this->getConnection();
        $query = $conn->prepare($sql);
        $query->bindValue(':id', $taskId);

        return $query->execute();
    }

    private function getConnection(): PDO
    {
        $app = Kernel::getInstance();

        return $app->getDbConnection();
    }
}
