<?php

namespace App\Twig\Extensions;
use App\Entity\Enums\Subjects\StatusEnum;
use App\Entity\Subject;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class IconExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('subject_status_icon', [$this, 'subjectStatusIcon']),
            new TwigFunction('theme_icon', [$this, 'themeIcon']),
        ];
    }

    public function subjectStatusIcon(Subject $subject): array
    {
        $icon = match ($subject->getStatus()) {
            StatusEnum::Active => [
                'class' => 'bi bi-check-circle',
                'color' => 'success',
            ],
            StatusEnum::Closed => [
                'class' => 'bi bi-x-circle',
                'color' => 'danger',
            ],
            StatusEnum::Verified => [
                'class' => 'bi bi-patch-check',
                'color' => 'primary',
            ],
            default => [
                'class' => 'bi bi-question-circle',
                'color' => 'warning',
            ],
        };
        return $icon;
    }

    public static function themeIcon(string $theme): array
    {
        $light = [
            'class' => 'bi-sun',
            'color' => 'light',
        ];
        $dark = [
            'class' => 'bi-moon',
            'color' => 'dark',
        ];
        return $theme === 'light' ? $dark : $light;
    }

}