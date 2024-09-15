<?php

namespace App\Form\Choices;
use App\Entity\Enums\Subjects\StatusEnum;

enum SubjectChoiceStatusEnum: string
{
    use ChoiceEnumTrait;

    case All = 'all';
    case Active = StatusEnum::Active->value;
    case Closed = StatusEnum::Closed->value;
    case Verified = StatusEnum::Verified->value;
}