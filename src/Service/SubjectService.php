<?php

namespace App\Service;
use App\Entity\Enums\Subjects\StatusEnum;
use App\Entity\Subject;
use Symfony\Component\HttpFoundation\Request;

class SubjectService extends AbstractService
{
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
}