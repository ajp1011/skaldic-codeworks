<?php

declare(strict_types=1);

namespace App\Enums;

enum UserType: string
{
    case SUPER_ADMINISTRATOR = 'super_administrator';
    case ADMINISTRATOR = 'administrator';
    case USER = 'user';
    case GUEST = 'guest';

    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMINISTRATOR => 'Super Administrator',
            self::ADMINISTRATOR => 'Administrator',
            self::USER => 'User',
            self::GUEST => 'Guest',
        };
    }

    public static function values(): array
    {
        return array_map(fn (self $type) => $type->value, self::cases());
    }

    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $type) {
            $options[$type->value] = $type->label();
        }

        return $options;
    }
}
