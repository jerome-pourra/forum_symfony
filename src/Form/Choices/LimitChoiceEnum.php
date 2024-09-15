<?php

namespace App\Form\Choices;

enum LimitChoiceEnum: int
{
    use ChoiceEnumTrait;

    case LIMIT_1 = 1;
    case LIMIT_5 = 5;
    case LIMIT_10 = 10;
    case LIMIT_15 = 15;
    case LIMIT_20 = 20;
    case LIMIT_25 = 25;
    case LIMIT_50 = 50;
    case LIMIT_100 = 100;
}