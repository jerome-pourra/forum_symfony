<?php

namespace App\Utils;
use Symfony\Component\HttpFoundation\Request;

class RequestContext
{

    private const MIN_LIMIT = 1;
    private const MAX_LIMIT = 50;
    private const DEFAULT_LIMIT = 10;

    private const MIN_OFFSET = 0;
    private const DEFAULT_OFFSET = 0;

    private Request $request;
    private array $filters = [];
    private ?int $limit = null;
    private ?int $offset = null;
    private ?string $orderBy = null;

    public function __construct(Request $request, array $filtersKeys = [])
    {

        $this->request = $request;

        $limit = $request->query->getInt('limit', self::DEFAULT_LIMIT);
        $this->limit = min(max($limit, self::MIN_LIMIT), self::MAX_LIMIT);

        $offset = $request->query->getInt('offset', self::DEFAULT_OFFSET);
        $this->offset = max($offset, self::MIN_OFFSET);

        $this->orderBy = $request->query->get('orderBy', null);

        $this->buildFilters($request, $filtersKeys);

    }

    public function getQueryParams(): array
    {
        return $this->request->query->all();
    }

    public function mergeQueryParams(array $params): array
    {
        return array_merge($this->request->query->all(), $params);
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    private function buildFilters(Request $request, array $keys): void
    {
        $this->filters = [];
        foreach ($keys as $key) {
            $value = $request->query->get($key);
            if ($value) {
                $this->filters[$key] = $value;
            }
        }
    }
}