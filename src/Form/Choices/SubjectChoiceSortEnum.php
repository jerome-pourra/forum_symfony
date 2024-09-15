<?php

namespace App\Form\Choices;

enum SubjectChoiceSortEnum: string
{
    use ChoiceEnumTrait;

    case CreatedAt = 'createdAt';
    case Title = 'title';
}