<?php

declare(strict_types=1);

namespace App\Enums;

enum UserType: string
{
    case SUPER_ADMINISTRATOR = 'super_administrator';
    case ADMINISTRATOR = 'administrator';
    case USER = 'user';
    case GUEST = 'guest';

    /**
     * Get the display label for the user type.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMINISTRATOR => 'Super Administrator',
            self::ADMINISTRATOR => 'Administrator',
            self::USER => 'User',
            self::GUEST => 'Guest',
        };
    }

    /**
     * Get all user type values.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_map(fn (self $type) => $type->value, self::cases());
    }

    /**
     * Get all user type labels.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $type) {
            $options[$type->value] = $type->label();
        }

        return $options;
    }
}
