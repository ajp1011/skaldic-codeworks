<?php

declare(strict_types=1);

namespace App\Enums;

enum Theme: string
{
    case NORDIC_MINIMALISM = 'nordic-minimalism';
    case FORGECRAFT_MODERN = 'forgecraft';

    /**
     * Get the slug for the theme.
     *
     * @return string
     */
    public function slug(): string
    {
        return $this->value;
    }

    /**
     * Get the display name for the theme.
     *
     * @return string
     */
    public function name(): string
    {
        return match ($this) {
            self::NORDIC_MINIMALISM => 'Nordic Minimalism',
            self::FORGECRAFT_MODERN => 'Forgecraft Modern',
        };
    }

    /**
     * Get the description for the theme.
     *
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::NORDIC_MINIMALISM => 'Cool, calm, minimalist Scandinavian design with icy blue accents',
            self::FORGECRAFT_MODERN => 'Modern foundry aesthetic with ember orange accents and industrial style',
        };
    }

    /**
     * Get the CSS path for the theme.
     *
     * @return string
     */
    public function cssPath(): string
    {
        return match ($this) {
            self::NORDIC_MINIMALISM => './nordic-minimalism/nordic-minimalism.css',
            self::FORGECRAFT_MODERN => './forgecraft/forgecraft.css',
        };
    }

    /**
     * Get the particle effect path for the theme.
     *
     * @return string
     */
    public function effectPath(): string
    {
        return match ($this) {
            self::NORDIC_MINIMALISM => './snow-effect',
            self::FORGECRAFT_MODERN => './spark-effect',
        };
    }

    /**
     * Get the text component name for the theme.
     *
     * @return string
     */
    public function textComponent(): string
    {
        return match ($this) {
            self::NORDIC_MINIMALISM => 'CarvedText',
            self::FORGECRAFT_MODERN => 'ForgedText',
        };
    }

    /**
     * Get the particle container ID for the theme.
     *
     * @return string
     */
    public function particleContainer(): string
    {
        return match ($this) {
            self::NORDIC_MINIMALISM => 'snow-container',
            self::FORGECRAFT_MODERN => 'spark-container',
        };
    }

    /**
     * Get all theme values.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_map(fn (self $theme) => $theme->value, self::cases());
    }

    /**
     * Get all theme options for forms.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $theme) {
            $options[$theme->value] = $theme->name();
        }

        return $options;
    }

    /**
     * Get theme instance from slug.
     *
     * @param string $slug
     * @return self
     */
    public static function fromSlug(string $slug): self
    {
        return self::from($slug);
    }
}
