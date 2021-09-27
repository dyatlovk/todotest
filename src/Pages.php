<?php

declare(strict_types=1);

namespace App;

use App\Model\Tasks;

class Pages
{
    private const MAX_ON_PAGE = 10;

    private string $key;
    private int $max;
    private int $current;
    /** @var array<string,mixed> */
    private array $request;

    public int $start;
    public int $end;

    /**
     * @param array<string,mixed> $request
     */
    public function __construct(string $queryKey = 'p', array $request, int $max = self::MAX_ON_PAGE)
    {
        $this->key = $queryKey;
        $this->max = $max;
        $this->request = $request;
        $this->current = (int) $request[$queryKey];
    }

    public function findBounding(): self
    {
        $start = ($this->current - 1) * $this->max;
        $end = $this->max;
        if (0 > $start) {
            $start = 0;
        }
        $this->start = $start;
        $this->end = $end;

        return $this;
    }

    /**
     * @return array<string>
     */
    public function buildQuery(): array
    {
        $taskModel = new Tasks();
        $pages = $taskModel->pages($this->max);
        unset($this->request[$this->key]);
        $prevQuery = '';
        if (false == empty($request)) {
            $prevQuery = '?' . http_build_query($this->request);
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
