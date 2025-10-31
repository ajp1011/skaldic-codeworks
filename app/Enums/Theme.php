<?php

declare(strict_types=1);

namespace App\Enums;

enum Theme: string
{
    case NORDIC_MINIMALISM = 'nordic-minimalism';
    case FORGECRAFT_MODERN = 'forgecraft';

    public function slug(): string
    {
        return $this->value;
    }

    public function name(): string
    {
        return match ($this) {
            self::NORDIC_MINIMALISM => 'Nordic Minimalism',
            self::FORGECRAFT_MODERN => 'Forgecraft Modern',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::NORDIC_MINIMALISM => 'Cool, calm, minimalist Scandinavian design with icy blue accents',
            self::FORGECRAFT_MODERN => 'Modern foundry aesthetic with ember orange accents and industrial style',
        };
    }

    public function cssPath(): string
    {
        return match ($this) {
            self::NORDIC_MINIMALISM => './nordic-minimalism/nordic-minimalism.css',
            self::FORGECRAFT_MODERN => './forgecraft/forgecraft.css',
        };
    }

    public function effectPath(): string
    {
        return match ($this) {
            self::NORDIC_MINIMALISM => './snow-effect',
            self::FORGECRAFT_MODERN => './spark-effect',
        };
    }

    public function particleContainer(): string
    {
        return match ($this) {
            self::NORDIC_MINIMALISM => 'snow-container',
            self::FORGECRAFT_MODERN => 'spark-container',
        };
    }

    public static function values(): array
    {
        return array_map(fn (self $theme) => $theme->value, self::cases());
    }

    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $theme) {
            $options[$theme->value] = $theme->name();
        }

        return $options;
    }

    public static function fromSlug(string $slug): self
    {
        return self::from($slug);
    }
}
