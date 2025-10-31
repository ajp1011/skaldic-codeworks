<?php

declare(strict_types=1);

use App\Enums\Theme;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;

uses(RefreshDatabase::class);

test('guest user can update theme', function () {
    $response = $this->postJson('/theme', [
        'theme' => 'forgecraft',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Theme updated successfully',
            'theme' => 'forgecraft',
        ]);

    $cacheControl = $response->headers->get('Cache-Control');
    expect($cacheControl)->toContain('no-cache')
        ->and($cacheControl)->toContain('no-store')
        ->and($cacheControl)->toContain('must-revalidate');

    $response->assertHeader('Pragma', 'no-cache');
    $response->assertHeader('Expires', '0');
});

test('authenticated user can update theme and database is updated', function () {
    $user = User::factory()->create([
        'theme' => Theme::NORDIC_MINIMALISM,
    ]);

    $this->actingAs($user);

    $response = $this->postJson('/theme', [
        'theme' => 'forgecraft',
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'message' => 'Theme updated successfully',
            'theme' => 'forgecraft',
        ]);

    $user->refresh();

    expect($user->theme)->toBe(Theme::FORGECRAFT_MODERN);
});

test('theme update requires valid theme enum value', function () {
    $response = $this->postJson('/theme', [
        'theme' => 'invalid-theme',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['theme']);
});

test('theme update requires theme field', function () {
    $response = $this->postJson('/theme', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['theme']);
});

test('authenticated user theme persists after multiple updates', function () {
    $user = User::factory()->create([
        'theme' => Theme::NORDIC_MINIMALISM,
    ]);

    $this->actingAs($user);

    $response = $this->postJson('/theme', [
        'theme' => 'forgecraft',
    ]);

    $response->assertStatus(200);

    $user->refresh();

    expect($user->theme)->toBe(Theme::FORGECRAFT_MODERN);

    $response = $this->postJson('/theme', [
        'theme' => 'nordic-minimalism',
    ]);

    $response->assertStatus(200);

    $user->refresh();

    expect($user->theme)->toBe(Theme::NORDIC_MINIMALISM);
});

test('theme update sets cookie for guest', function () {
    $response = $this->postJson('/theme', [
        'theme' => 'forgecraft',
    ]);

    $response->assertStatus(200);

    $cookies = $response->headers->getCookies();
    $themeCookie = collect($cookies)->first(fn ($cookie) => $cookie->getName() === 'theme');

    expect($themeCookie)->not->toBeNull();

    $cookieValue = $themeCookie->getValue();

    try {
        $actualValue = Crypt::decryptString($cookieValue);
    } catch (\Exception $e) {
        $actualValue = $cookieValue;
    }
    $parts = explode('|', $actualValue, 2);
    $actualValue = $parts[1] ?? $actualValue;

    expect($actualValue)->toBe('forgecraft');
});

test('theme update sets cookie for authenticated user', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->postJson('/theme', [
        'theme' => 'nordic-minimalism',
    ]);

    $response->assertStatus(200);

    $cookies = $response->headers->getCookies();
    $themeCookie = collect($cookies)->first(fn ($cookie) => $cookie->getName() === 'theme');

    expect($themeCookie)->not->toBeNull();

    $cookieValue = $themeCookie->getValue();

    try {
        $actualValue = Crypt::decryptString($cookieValue);
    } catch (\Exception $e) {
        $actualValue = $cookieValue;
    }
    $parts = explode('|', $actualValue, 2);
    $actualValue = $parts[1] ?? $actualValue;

    expect($actualValue)->toBe('nordic-minimalism');
});
