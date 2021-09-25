<?php

declare(strict_types=1);

namespace App\Model;

use App\System\Dbase;

class Task
{
    public const STATUS_OPEN = 1;
    public const STATUS_CLOSE = 2;
    public const STATUS_COMPLETE = 3;
    public const STATUSES = [
        self::STATUS_CLOSE => 'Closed',
        self::STATUS_COMPLETE => 'Completed',
        self::STATUS_OPEN => 'Open',
    ];

    public function getAll(): array
    {
        $db = new Dbase();
        $conn = $db->connect();
        $sql = 'SELECT t.title as task_title, t.id as task_id,
        t.text as task_text, t.status as task_status, u.username as user_name,
        u.email as user_email FROM tasks t INNER JOIN user u ON u.id = t.user_id';
        $query = $conn->query($sql);
        if (false == $query) {
            return [];
        }
        $result = $query->fetchAll();
        if (false == $result) {
            return [];
        }

        return $result;
    }
}
