<?php

namespace App\Service;
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

    public function getFilterKeys(): array
    {
        // TODO: Comment filtrer sur un nom d'utilisateur par exemple ? (sub entity)
        // TODO: Comment accepter uniquement certaines valeurs dans les filtres ?
        // TODO: Pour la recherche sur le titre, comment faire une recherche partielle ? %LIKE% ?
        return [
            'title',
            'status',
        ];
    }

    public function getAll(Request $request): array
    {
        $context = new RequestContext($request, $this->getFilterKeys());
        return $this->em->getRepository($this->getRepository())->findBy($context->getFilters(), $context->getOrderBy(), $context->getLimit(), $context->getOffset());
    }
}