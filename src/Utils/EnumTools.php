<?php

namespace App\Utils;

class EnumTools
{
    /**
     * @template T
     * @param class-string<T> $enum
     * @return T
     */
    public static function getRandomEnumValue(string $enum): mixed
    {
        return $enum::cases()[array_rand($enum::cases())];
    }
}