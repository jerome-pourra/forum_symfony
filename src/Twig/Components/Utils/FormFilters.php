<?php

namespace App\Twig\Components\Utils;
use Symfony\Component\Form\FormView;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class FormFilters
{
    public FormView $form;
}