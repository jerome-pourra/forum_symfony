<?php

namespace App\Service;
use App\Utils\RequestContext;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class AbstractService
{
    public function __construct(
        protected EntityManagerInterface $em,
        private UrlGeneratorInterface $router
    ) {
        $this->em = $em;
    }

    abstract public function getRepository(): string;

    public function getFilters(Request $request): array
    {
        return [];
    }

    public function getList(Request $request, array $extraFilters = []): array
    {
        $context = new RequestContext($request, $this->router);
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

    public function getOne(int $id): object
    {
        return $this->fetchOne(['id' => $id]);
    }

    protected function fetchList(RequestContext $context, array $criterias): array
    {
        $items = $this->em->getRepository($this->getRepository())->findBy($criterias, $context->getOrderBy(), $context->getLimit(), $context->getOffset());
        $count = $this->fetchCount($criterias);
        return [
            'items' => $items,
            'count' => $count,
            'context' => $context,
        ];
    }

    protected function fetchOne(array $criterias): object
    {
        return $this->em->getRepository($this->getRepository())->findOneBy($criterias);
    }

    protected function fetchCount(array $criterias): int
    {
        return $this->em->getRepository($this->getRepository())->count($criterias);
    }
}