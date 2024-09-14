<?php

namespace App\Twig\Components\Subject;
use App\Entity\Enums\Subjects\StatusEnum;
use App\Entity\Subject;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class SubjectRow
{

    public Subject $subject;

    public function getIconFromStatus(): array
    {
        $icon = match ($this->subject->getStatus()) {
            StatusEnum::Active => [
                'icon' => 'check_circle',
                'color' => 'success',
            ],
            StatusEnum::Closed => [
                'icon' => 'cancel',
                'color' => 'danger',
            ],
            StatusEnum::Verified => [
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