<?php

namespace App\Form\Choices;

enum ChoiceSortOperatorEnum: string
{
    use ChoiceEnumTrait;

    case Ascending = 'ASC';
    case Descending = 'DESC';
}