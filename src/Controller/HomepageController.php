<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Tasks;

class HomepageController extends BaseController
{
    private const ITEMS_ON_PAGE = 10;

    public function index(): string
    {
        $page = (int) $_REQUEST['p'];
        if (1 == $page) {
            $page = 0;
        }
        $taskModel = new Tasks();
        $startFrom = ($page - 1) * self::ITEMS_ON_PAGE;
        $list = $taskModel->getAll($startFrom, self::ITEMS_ON_PAGE);
        $pages = $taskModel->pages(self::ITEMS_ON_PAGE);

        return $this->render('home/index.php', [
            'taskList' => $list,
            'pages' => $pages,
        ]);
    }
}
