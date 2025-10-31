<?php

declare(strict_types=1);

namespace App\Actions\Theme;

use App\Enums\Theme;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

class UpdateThemeAction
{
    public function execute(string $themeSlug, ?Authenticatable $user = null): string
    {
        $theme = Theme::fromSlug($themeSlug);

        if ($user instanceof User) {
            $user->update(['theme' => $theme]);
        }

        cookie()->queue('theme', $themeSlug, 525600, '/');

        return $themeSlug;
    }
}
