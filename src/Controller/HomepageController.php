<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Tasks;
use App\Order;
use App\Pages;

class HomepageController extends BaseController
{
    private const ITEMS_ON_PAGE = 5;

    public function index(): string
    {
        $order = new Order('sort', 'dir', $_REQUEST);
        $pages = new Pages('p', $_REQUEST, self::ITEMS_ON_PAGE);
        $taskModel = new Tasks();
        $tasksStartAt = $pages->findBounding()->start;
        $tasksLimit = $pages->findBounding()->end;
        $tasksOrderExpr = $order->prepareSql();
        $list = $taskModel->getAll($tasksStartAt, $tasksLimit, $tasksOrderExpr);

        return $this->render('home/index.php', [
            'taskList' => $list,
            'orderQuery' => $order->buildQuery(),
            'pageQuery' => $pages->buildQuery(),
        ]);
    }
}
