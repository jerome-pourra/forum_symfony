<?php

namespace App\Form\Choices;

trait ChoiceEnumTrait
{
    public static function getChoices(): array
    {
        /** @var \BackedEnum[] $enums */
        $enums = self::cases();

        return array_combine(
            array_map(fn(\BackedEnum $enum) => $enum->name, $enums),
            array_map(fn(\BackedEnum $enum) => $enum->value, $enums)
        );
    }

    public static function getChoicesWithNames(): array
    {
        /** @var \BackedEnum[] $enums */
        $enums = self::cases();

        return array_combine(
            array_map(fn($enum) => $enum->name, $enums),
            array_map(fn($enum) => $enum->name, $enums)
        );
    }

    public static function getChoicesWithValues(): array
    {
        /** @var \BackedEnum[] $enums */
        $enums = self::cases();

        return array_combine(
            array_map(fn($enum) => (string) $enum->value, $enums),
            array_map(fn($enum) => $enum->value, $enums)
        );
    }
}