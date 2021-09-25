<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Tasks;
use App\System\Templates;

class HomepageController
{
    private const ITEMS_ON_PAGE = 4;

    public function index(): void
    {
        $page = (int) $_REQUEST['p'];
        if (1 == $page) {
            $page = 0;
        }
        $taskModel = new Tasks();
        $startFrom = ($page - 1) * self::ITEMS_ON_PAGE;
        $list = $taskModel->getAll($startFrom, self::ITEMS_ON_PAGE);
        $pages = $taskModel->pages(self::ITEMS_ON_PAGE);
        echo (new Templates())->render('home/index.php', [
            'taskList' => $list,
            'pages' => $pages,
        ]);
    }
}
