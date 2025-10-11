<?php

declare(strict_types=1);

use App\Actions\Auth\{LoginUserAction, LogoutUserAction};
use App\Http\Controllers\Auth\LoginController;
use Illuminate\View\View;

beforeEach(function () {
    $this->loginUserAction = mock(LoginUserAction::class);
    $this->logoutUserAction = mock(LogoutUserAction::class);

    $this->controller = new LoginController(
        $this->loginUserAction,
        $this->logoutUserAction
    );
});

test('controller is instantiated with actions via dependency injection', function () {
    expect($this->controller)->toBeInstanceOf(LoginController::class);
});

test('show method returns login view', function () {
    $response = $this->controller->show();

    expect($response)->toBeInstanceOf(View::class)
        ->and($response->name())->toBe('auth.login');
});

// Note: Full integration tests for store() and destroy() methods including redirects
// should be tested in Feature tests, not Unit tests, as they require the full
// HTTP infrastructure (routing, sessions, redirects, etc.)
//
// Unit tests for controllers focus on:
// - Constructor injection
// - View rendering
// - Business logic delegation to actions
//
// See tests/Feature/Auth/LoginControllerTest.php for full HTTP flow testing
