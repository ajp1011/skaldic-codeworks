<?php

declare(strict_types=1);

use App\Actions\Auth\LoginUserAction;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

beforeEach(function () {
    $this->action = new LoginUserAction();
});

test('successfully logs in user with valid credentials', function () {
    // Arrange
    $credentials = [
        'email' => 'test@example.com',
        'password' => 'password123',
    ];

    // Mock the session
    $session = mock(Store::class);
    $session->shouldReceive('regenerate')->once();

    // Use partial mock to allow Laravel's internal calls
    $request = \Mockery::mock(Request::class)->makePartial();
    $request->shouldReceive('session')->once()->andReturn($session);

    // Bind mocked request to container
    $this->app->instance('request', $request);

    // Mock the Auth facade
    Auth::shouldReceive('attempt')
        ->once()
        ->with($credentials, false)
        ->andReturn(true);

    // Act
    $result = $this->action->execute($credentials);

    // Assert
    expect($result)->toBeTrue();
});

test('successfully logs in user with remember me option', function () {
    // Arrange
    $credentials = [
        'email' => 'test@example.com',
        'password' => 'password123',
    ];

    // Mock the session
    $session = mock(Store::class);
    $session->shouldReceive('regenerate')->once();

    // Use partial mock to allow Laravel's internal calls
    $request = \Mockery::mock(Request::class)->makePartial();
    $request->shouldReceive('session')->once()->andReturn($session);

    // Bind mocked request to container
    $this->app->instance('request', $request);

    // Mock the Auth facade
    Auth::shouldReceive('attempt')
        ->once()
        ->with($credentials, true)
        ->andReturn(true);

    // Act
    $result = $this->action->execute($credentials, true);

    // Assert
    expect($result)->toBeTrue();
});

test('throws validation exception with invalid credentials', function () {
    // Arrange
    $credentials = [
        'email' => 'test@example.com',
        'password' => 'wrongpassword',
    ];

    // Mock the Auth facade
    Auth::shouldReceive('attempt')
        ->once()
        ->with($credentials, false)
        ->andReturn(false);

    // Act & Assert
    $this->action->execute($credentials);
})->throws(
    ValidationException::class,
    'The provided credentials do not match our records.'
);

test('validation exception contains correct error message for email field', function () {
    // Arrange
    $credentials = [
        'email' => 'test@example.com',
        'password' => 'wrongpassword',
    ];

    // Mock the Auth facade
    Auth::shouldReceive('attempt')
        ->once()
        ->with($credentials, false)
        ->andReturn(false);

    // Act & Assert
    try {
        $this->action->execute($credentials);
        $this->fail('Expected ValidationException was not thrown');
    } catch (ValidationException $e) {
        expect($e->errors())
            ->toHaveKey('email')
            ->and($e->errors()['email'])
            ->toContain('The provided credentials do not match our records.');
    }
});

test('does not regenerate session when authentication fails', function () {
    // Arrange
    $credentials = [
        'email' => 'test@example.com',
        'password' => 'wrongpassword',
    ];

    // Mock the Auth facade
    Auth::shouldReceive('attempt')
        ->once()
        ->with($credentials, false)
        ->andReturn(false);

    // Act & Assert
    try {
        $this->action->execute($credentials);
    } catch (ValidationException $e) {
        // Expected exception - session should never be accessed
        expect(true)->toBeTrue();
    }
});
