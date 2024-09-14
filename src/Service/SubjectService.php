<?php

namespace App\Service;
use App\Entity\Enums\Subjects\StatusEnum;
use App\Entity\Subject;
use App\Utils\RequestContext;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class SubjectService
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getRepository(): string
    {
        return Subject::class;
    }

    public function getFilters(Request $request): array
    {

        // TODO: Comment filtrer sur un nom d'utilisateur par exemple ? (sub entity)
        // TODO: Comment accepter uniquement certaines valeurs dans les filtres ?
        // TODO: Pour la recherche sur le titre, comment faire une recherche partielle ? %LIKE% ?

        $filters = [];

        if ($request->query->has('status')) {

            $requestStatus = $request->query->get('status');
            $status = match ($requestStatus) {
                'active' => $filters['status'] = StatusEnum::Active,
                'closed' => $filters['status'] = StatusEnum::Closed,
                'verified' => $filters['status'] = StatusEnum::Verified,
                default => null,
            };

            if ($status !== null) {
                $filters['status'] = $status;
            }

        }

        return $filters;

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