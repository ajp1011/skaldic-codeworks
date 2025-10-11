<?php

declare(strict_types=1);

use App\Actions\Auth\LogoutUserAction;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;

beforeEach(function () {
    $this->action = new LogoutUserAction();
});

test('successfully logs out user', function () {
    // Mock the session
    $session = mock(Store::class);
    $session->shouldReceive('invalidate')->once();
    $session->shouldReceive('regenerateToken')->once();

    // Use partial mock to allow Laravel's internal calls
    $request = \Mockery::mock(Request::class)->makePartial();
    $request->shouldReceive('session')->twice()->andReturn($session);

    // Bind mocked request to container
    $this->app->instance('request', $request);

    // Mock the Auth facade
    Auth::shouldReceive('logout')->once();

    // Act
    $this->action->execute();

    // Assert - if no exception is thrown, the test passes
    expect(true)->toBeTrue();
});

test('calls Auth logout method', function () {
    // Mock the session
    $session = mock(Store::class);
    $session->shouldReceive('invalidate')->once();
    $session->shouldReceive('regenerateToken')->once();

    // Use partial mock to allow Laravel's internal calls
    $request = \Mockery::mock(Request::class)->makePartial();
    $request->shouldReceive('session')->twice()->andReturn($session);

    // Bind mocked request to container
    $this->app->instance('request', $request);

    // Mock the Auth facade - verify it's called
    Auth::shouldReceive('logout')->once();

    // Act
    $this->action->execute();
});

test('invalidates session during logout', function () {
    // Mock the session - verify invalidate is called
    $session = mock(Store::class);
    $session->shouldReceive('invalidate')->once();
    $session->shouldReceive('regenerateToken')->once();

    // Use partial mock to allow Laravel's internal calls
    $request = \Mockery::mock(Request::class)->makePartial();
    $request->shouldReceive('session')->twice()->andReturn($session);

    // Bind mocked request to container
    $this->app->instance('request', $request);

    // Mock the Auth facade
    Auth::shouldReceive('logout')->once();

    // Act
    $this->action->execute();
});

test('regenerates token during logout', function () {
    // Mock the session - verify regenerateToken is called
    $session = mock(Store::class);
    $session->shouldReceive('invalidate')->once();
    $session->shouldReceive('regenerateToken')->once();

    // Use partial mock to allow Laravel's internal calls
    $request = \Mockery::mock(Request::class)->makePartial();
    $request->shouldReceive('session')->twice()->andReturn($session);

    // Bind mocked request to container
    $this->app->instance('request', $request);

    // Mock the Auth facade
    Auth::shouldReceive('logout')->once();

    // Act
    $this->action->execute();
});

test('performs logout operations in correct order', function () {
    // Mock the Auth facade - logout should happen first
    Auth::shouldReceive('logout')->once()->ordered();

    // Mock the session
    $session = mock(Store::class);
    $session->shouldReceive('invalidate')->once()->ordered();
    $session->shouldReceive('regenerateToken')->once()->ordered();

    // Use partial mock to allow Laravel's internal calls
    $request = \Mockery::mock(Request::class)->makePartial();
    $request->shouldReceive('session')->twice()->andReturn($session);

    // Bind mocked request to container
    $this->app->instance('request', $request);

    // Act
    $this->action->execute();
});
