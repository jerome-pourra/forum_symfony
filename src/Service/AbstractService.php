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

    public function getList(Request $request): array {

        $context = new RequestContext($request);
        $filters = $this->getFilters($request);
        $items = $this->em->getRepository($this->getRepository())->findBy($filters, $context->getOrderBy(), $context->getLimit(), $context->getOffset());
        $count = count($this->em->getRepository($this->getRepository())->findBy($filters));

        return [
            'items' => $items,
            'count' => $count,
            'context' => $context,
        ];
        
    }
}