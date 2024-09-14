<?php

namespace App\Entity\Enums\Subjects;

enum StatusEnum: string
{
    case ACTIVE = 'active';
    case CLOSED = 'closed';
    case VERIFIED = 'verified';
}