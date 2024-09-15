<?php

namespace App\Service;
use App\Entity\Message;
use App\Entity\Subject;
use App\Utils\RequestContext;
use Symfony\Component\HttpFoundation\Request;

class MessageService extends AbstractService
{
    public function getRepository(): string
    {
        return Message::class;
    }

    public function getFilters(Request $request): array
    {
        return [];
    }

    public function getListFromSubject(Request $request, Subject $entity): array
    {

        // TODO: Refacto en gros ici on fait rien de + que merge les filtres de base avec un filtre supplémentaire
        $extraFilters = ['subject' => $entity];
        $context = new RequestContext($request);
        $filters = array_merge($extraFilters, $this->getFilters($request));
        $items = $this->em->getRepository($this->getRepository())->findBy($filters, $context->getOrderBy(), $context->getLimit(), $context->getOffset());
        $count = count($this->em->getRepository($this->getRepository())->findBy($filters));

        return [
            'items' => $items,
            'count' => $count,
            'context' => $context,
        ];


    }
}