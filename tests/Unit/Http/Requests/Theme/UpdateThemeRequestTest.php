<?php

declare(strict_types=1);

use App\Http\Requests\Theme\UpdateThemeRequest;
use Illuminate\Support\Facades\Validator;

test('validates theme is required', function () {
    $request = new UpdateThemeRequest();
    $rules = $request->rules();

    $validator = Validator::make([], $rules);

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has('theme'))->toBeTrue();
});

test('validates theme must be valid enum value', function () {
    $request = new UpdateThemeRequest();
    $rules = $request->rules();

    $validator = Validator::make(['theme' => 'invalid-theme'], $rules);

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has('theme'))->toBeTrue();
});

test('passes validation with nordic minimalism theme', function () {
    $request = new UpdateThemeRequest();
    $rules = $request->rules();

    $validator = Validator::make(['theme' => 'nordic-minimalism'], $rules);

    expect($validator->passes())->toBeTrue();
});

test('passes validation with forgecraft theme', function () {
    $request = new UpdateThemeRequest();
    $rules = $request->rules();

    $validator = Validator::make(['theme' => 'forgecraft'], $rules);

    expect($validator->passes())->toBeTrue();
});

test('authorize returns true', function () {
    $request = new UpdateThemeRequest();

    expect($request->authorize())->toBeTrue();
});
