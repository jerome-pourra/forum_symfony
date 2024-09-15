<?php

namespace App\Service;
use App\Utils\RequestContext;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractService
{
    protected EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    abstract public function getRepository(): string;

    public function getFilters(Request $request): array
    {
        return [];
    }

    public function getList(Request $request, array $extraFilters = []): array
    {
        $context = new RequestContext($request);
        $filters = $this->getFilters($request);
        $filters = array_merge($filters, $extraFilters);
        return $this->fetchList($context, $filters);
    }

    public function getListByKeys(Request $request, array $extraFilters): array
    {
        return $this->getList($request, $extraFilters);
    }

    public function getListByKey(Request $request, string $key, mixed $value): array
    {
        return $this->getList($request, [$key => $value]);
    }

    public function getListById(Request $request, int $id): array
    {
        return $this->getList($request, ['id' => $id]);
    }

    private function fetchList(RequestContext $context, array $criterias): array
    {
        $items = $this->em->getRepository($this->getRepository())->findBy($criterias, $context->getOrderBy(), $context->getLimit(), $context->getOffset());
        $count = count($this->em->getRepository($this->getRepository())->findBy($criterias));
        return [
            'items' => $items,
            'count' => $count,
            'context' => $context,
        ];
    }
}