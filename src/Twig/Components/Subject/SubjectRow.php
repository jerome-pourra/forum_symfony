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