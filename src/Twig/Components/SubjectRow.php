<?php

namespace App\Twig\Components;
use App\Entity\Enums\Subjects\StatusEnum;
use App\Entity\Subject;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(template: 'components/subject/subject_row.html.twig')]
class SubjectRow
{

    public Subject $subject;

    public function getIconFromStatus(): array
    {
        $icon = match ($this->subject->getStatus()) {
            StatusEnum::ACTIVE => [
                'icon' => 'check_circle',
                'color' => 'success',
            ],
            StatusEnum::CLOSED => [
                'icon' => 'cancel',
                'color' => 'danger',
            ],
            StatusEnum::VERIFIED => [
                'icon' => 'verified',
                'color' => 'primary',
            ],
            default => [
                'icon' => 'help',
                'color' => 'warning',
            ],
        };
        return $icon;
    }

}