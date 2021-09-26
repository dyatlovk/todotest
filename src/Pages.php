<?php

declare(strict_types=1);

namespace App;

use App\Model\Tasks;

class Pages
{
    private const MAX = 10;

    private string $key;
    private int $max;
    private int $current;

    public function __construct(string $key = 'p', int $current, $max = self::MAX)
    {
        $this->key = $key;
        $this->max = $max;
        $this->current = $current;
    }

    public function getRanges(): array
    {
        $start = ($this->current - 1) * $this->max;
        $end = $this->max;
        if (0 > $start) {
            $start = 0;
        }

        return [
            'start' => $start,
            'end' => $end,
        ];
    }

    public function getQuery(): array
    {
        $taskModel = new Tasks();
        $pages = $taskModel->pages($this->max);
        $request = $_REQUEST;
        unset($request[$this->key]);
        $prevQuery = '';
        if (false == empty($request)) {
            $prevQuery = '?' . http_build_query($request);
        }
        $prefix = '&';
        if (empty($request)) {
            $prefix = '?';
        }

        $result = [];
        for ($i = 1; $i <= $pages; ++$i) {
            $pageQuery = $prefix . $this->key . '=' . $i;
            $query = $prevQuery . $pageQuery;
            $result[$i] = $query;
        }

        return $result;
    }
}
