<?php

declare(strict_types=1);

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Validator;

test('authorize returns true', function () {
    $request = new LoginRequest();

    expect($request->authorize())->toBeTrue();
});

test('rules include email as required string and email', function () {
    $request = new LoginRequest();
    $rules = $request->rules();

    expect($rules)->toHaveKey('email')
        ->and($rules['email'])->toContain('required')
        ->and($rules['email'])->toContain('string')
        ->and($rules['email'])->toContain('email');
});

test('rules include password as required string', function () {
    $request = new LoginRequest();
    $rules = $request->rules();

    expect($rules)->toHaveKey('password')
        ->and($rules['password'])->toContain('required')
        ->and($rules['password'])->toContain('string');
});

test('rules include remember as nullable boolean', function () {
    $request = new LoginRequest();
    $rules = $request->rules();

    expect($rules)->toHaveKey('remember')
        ->and($rules['remember'])->toContain('nullable')
        ->and($rules['remember'])->toContain('boolean');
});

test('validation passes with valid email and password', function () {
    $request = new LoginRequest();

    $validator = Validator::make([
        'email' => 'test@example.com',
        'password' => 'password123',
    ], $request->rules());

    expect($validator->passes())->toBeTrue();
});

test('validation passes with valid email password and remember true', function () {
    $request = new LoginRequest();

    $validator = Validator::make([
        'email' => 'test@example.com',
        'password' => 'password123',
        'remember' => true,
    ], $request->rules());

    expect($validator->passes())->toBeTrue();
});

test('validation passes with valid email password and remember false', function () {
    $request = new LoginRequest();

    $validator = Validator::make([
        'email' => 'test@example.com',
        'password' => 'password123',
        'remember' => false,
    ], $request->rules());

    expect($validator->passes())->toBeTrue();
});

test('validation passes without remember field', function () {
    $request = new LoginRequest();

    $validator = Validator::make([
        'email' => 'test@example.com',
        'password' => 'password123',
    ], $request->rules());

    expect($validator->passes())->toBeTrue();
});

test('validation fails without email', function () {
    $request = new LoginRequest();

    $validator = Validator::make([
        'password' => 'password123',
    ], $request->rules());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has('email'))->toBeTrue();
});

test('validation fails without password', function () {
    $request = new LoginRequest();

    $validator = Validator::make([
        'email' => 'test@example.com',
    ], $request->rules());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has('password'))->toBeTrue();
});

test('validation fails with invalid email format', function () {
    $request = new LoginRequest();

    $validator = Validator::make([
        'email' => 'not-an-email',
        'password' => 'password123',
    ], $request->rules());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has('email'))->toBeTrue();
});

test('validation fails with empty email', function () {
    $request = new LoginRequest();

    $validator = Validator::make([
        'email' => '',
        'password' => 'password123',
    ], $request->rules());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has('email'))->toBeTrue();
});

test('validation fails with empty password', function () {
    $request = new LoginRequest();

    $validator = Validator::make([
        'email' => 'test@example.com',
        'password' => '',
    ], $request->rules());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has('password'))->toBeTrue();
});

test('validation fails with non boolean remember value', function () {
    $request = new LoginRequest();

    $validator = Validator::make([
        'email' => 'test@example.com',
        'password' => 'password123',
        'remember' => 'not-a-boolean',
    ], $request->rules());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has('remember'))->toBeTrue();
});
