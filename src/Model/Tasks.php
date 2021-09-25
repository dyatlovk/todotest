<?php

declare(strict_types=1);

namespace App\Model;

use App\System\Kernel;
use PDO;

class Tasks
{
    public const STATUS_OPEN = 1;
    public const STATUS_CLOSE = 2;
    public const STATUS_COMPLETE = 3;
    public const STATUSES = [
        self::STATUS_CLOSE => 'Closed',
        self::STATUS_COMPLETE => 'Completed',
        self::STATUS_OPEN => 'Open',
    ];
    public const MAX_ITEMS = 10;

    public function getAll(int $startFrom = 0, int $limit = self::MAX_ITEMS): array
    {
        if (0 > $startFrom) {
            $startFrom = 0;
        }
        $conn = $this->getConnection();
        $sql = 'SELECT t.title as task_title, t.id as task_id,
        t.text as task_text, t.status as task_status, u.username as user_name,
        u.email as user_email FROM tasks t INNER JOIN user u ON u.id = t.user_id
        LIMIT :limit OFFSET :offset';
        $query = $conn->prepare($sql);
        if (false == $query) {
            return [];
        }
        $query->bindValue(':limit', $limit, PDO::PARAM_INT);
        $query->bindValue(':offset', $startFrom, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll();
        if (false == $result) {
            return [];
        }

        return $result;
    }

    public function findById(int $id): array
    {
        $conn = $this->getConnection();
        $sql = 'SELECT t.id as task_id, t.title as task_title, t.text as task_text,
        t.status as task_status FROM tasks t WHERE t.id = :task_id';

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
        $conn = $this->getConnection();
        $sql = 'SELECT COUNT(t.id) as count FROM tasks t';
        $query = $conn->query($sql)->fetch();

        if (isset($query['count'])) {
            return (int) $query['count'];
        }

        return null;
    }

    public function getStatusesList(int $actual): array
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

    private function getConnection(): PDO
    {
        $app = Kernel::getInstance();

        return $app->getDbConnection();
    }
}
