<?php

declare(strict_types=1);

namespace App\Developer\Entity\ValueObject;

enum Position: string
{
    case Programmer = 'programmer';
    case Designer = 'designer';
    case Administrator = 'administrator';
    case Devops = 'devops';

    /**
     * @return array<string>
     */
    public static function casesAtString(): array
    {
        return array_map(static fn (self $case): string => $case->value, self::cases());
    }
}
