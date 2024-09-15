<?php

namespace App\Service;
use App\Entity\Message;
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
}