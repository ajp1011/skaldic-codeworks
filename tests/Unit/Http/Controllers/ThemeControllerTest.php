<?php

declare(strict_types=1);

use App\Actions\Theme\UpdateThemeAction;
use App\Http\Controllers\ThemeController;
use App\Http\Requests\Theme\UpdateThemeRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->updateThemeAction = mock(UpdateThemeAction::class);
    $this->controller = new ThemeController($this->updateThemeAction);
});

test('controller is instantiated with action via dependency injection', function () {
    expect($this->controller)->toBeInstanceOf(ThemeController::class);
});

test('update method calls action and returns json response', function () {
    $request = mock(UpdateThemeRequest::class);
    $request->shouldReceive('validated')
        ->once()
        ->andReturn(['theme' => 'forgecraft']);

    Auth::shouldReceive('user')
        ->once()
        ->andReturn(null);

    $this->updateThemeAction
        ->shouldReceive('execute')
        ->once()
        ->with('forgecraft', null)
        ->andReturn('forgecraft');

    $response = $this->controller->update($request);

    expect($response)->toBeInstanceOf(JsonResponse::class)
        ->and($response->getData(true))
        ->toHaveKey('message')
        ->toHaveKey('theme')
        ->and($response->getData(true)['theme'])->toBe('forgecraft')
        ->and($response->getData(true)['message'])->toBe('Theme updated successfully');
});

test('update method passes authenticated user to action', function () {
    $user = User::factory()->create();

    $request = mock(UpdateThemeRequest::class);
    $request->shouldReceive('validated')
        ->once()
        ->andReturn(['theme' => 'nordic-minimalism']);

    Auth::shouldReceive('user')
        ->once()
        ->andReturn($user);

    $this->updateThemeAction
        ->shouldReceive('execute')
        ->once()
        ->with('nordic-minimalism', $user)
        ->andReturn('nordic-minimalism');

    $response = $this->controller->update($request);

    expect($response)->toBeInstanceOf(JsonResponse::class);
});

test('update method returns response with cache headers', function () {
    $request = mock(UpdateThemeRequest::class);
    $request->shouldReceive('validated')
        ->once()
        ->andReturn(['theme' => 'forgecraft']);

    Auth::shouldReceive('user')
        ->once()
        ->andReturn(null);

    $this->updateThemeAction
        ->shouldReceive('execute')
        ->once()
        ->andReturn('forgecraft');

    $response = $this->controller->update($request);

    // Cache-Control header may have additional values like "private" and order may vary
    $cacheControl = $response->headers->get('Cache-Control');
    expect($cacheControl)->toContain('no-cache')
        ->and($cacheControl)->toContain('no-store')
        ->and($cacheControl)->toContain('must-revalidate');

    expect($response->headers->get('Pragma'))->toBe('no-cache')
        ->and($response->headers->get('Expires'))->toBe('0');
});
