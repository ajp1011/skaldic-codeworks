<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Theme\UpdateThemeAction;
use App\Http\Requests\Theme\UpdateThemeRequest;
use Illuminate\Http\JsonResponse;

class ThemeController
{
    public function __construct(
        private readonly UpdateThemeAction $updateThemeAction
    ) {}  

    public function update(UpdateThemeRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $themeSlug = $validated['theme'];

        $updatedTheme = $this->updateThemeAction->execute(
            $themeSlug,
            $request->user()
        );

        return response()->json([
            'message' => 'Theme updated successfully',
            'theme' => $updatedTheme,
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate')
          ->header('Pragma', 'no-cache')
          ->header('Expires', '0');
    }
}
