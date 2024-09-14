<?php

namespace App\Utils;
use Symfony\Component\HttpFoundation\Request;

class RequestContext
{
    private Request $request;
    private array $filters = [];
    private ?int $limit = null;
    private ?int $offset = null;
    private ?string $orderBy = null;

    public function __construct(Request $request, array $filtersKeys = [])
    {
        $this->request = $request;
        $this->limit = $request->query->get('limit');
        $this->offset = $request->query->get('offset');
        $this->orderBy = $request->query->get('orderBy');
        $this->buildFilters($request, $filtersKeys);
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