<?php

namespace App\Service;
use App\Entity\Message;
use App\Entity\Subject;
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

    public function getCountBySubject(Subject $subject): int
    {
        return $this->em->getRepository($this->getRepository())->count(['subject' => $subject]);
    }
}