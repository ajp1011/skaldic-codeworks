<?php

declare(strict_types=1);

use App\Actions\Theme\UpdateThemeAction;
use App\Enums\Theme;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->action = new UpdateThemeAction();
});

test('successfully updates theme for guest user', function () {
    $themeSlug = 'forgecraft';

    $result = $this->action->execute($themeSlug, null);

    expect($result)->toBe($themeSlug);
});

test('successfully updates theme for authenticated user', function () {
    $user = User::factory()->create([
        'theme' => Theme::NORDIC_MINIMALISM,
    ]);

    $themeSlug = 'forgecraft';

    $result = $this->action->execute($themeSlug, $user);

    expect($result)->toBe($themeSlug);

    $user->refresh();

    expect($user->theme)->toBe(Theme::FORGECRAFT_MODERN);
});

test('successfully updates theme to nordic minimalism', function () {
    $user = User::factory()->create([
        'theme' => Theme::FORGECRAFT_MODERN,
    ]);

    $themeSlug = 'nordic-minimalism';

    $result = $this->action->execute($themeSlug, $user);

    expect($result)->toBe($themeSlug);

    $user->refresh();

    expect($user->theme)->toBe(Theme::NORDIC_MINIMALISM);
});

test('does not update database for guest user', function () {
    $themeSlug = 'forgecraft';

    $userCountBefore = User::count();

    $result = $this->action->execute($themeSlug, null);

    expect($result)->toBe($themeSlug)
        ->and(User::count())->toBe($userCountBefore);
});

test('updates cookie for guest user', function () {
    $themeSlug = 'forgecraft';

    $result = $this->action->execute($themeSlug, null);

    expect($result)->toBe($themeSlug);
});

test('updates both database and cookie for authenticated user', function () {
    $user = User::factory()->create([
        'theme' => Theme::NORDIC_MINIMALISM,
    ]);

    $themeSlug = 'forgecraft';

    $result = $this->action->execute($themeSlug, $user);

    expect($result)->toBe($themeSlug);

    $user->refresh();

    expect($user->theme)->toBe(Theme::FORGECRAFT_MODERN);
});
