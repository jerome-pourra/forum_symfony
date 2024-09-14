<?php

namespace App\Entity\Enums\Subjects;

enum StatusEnum: string
{
    case Active = 'active';
    case Closed = 'closed';
    case Verified = 'verified';
}