<?php

declare(strict_types=1);

use App\Enums\UserType;

test('has all expected cases', function () {
    $cases = UserType::cases();

    expect($cases)->toHaveCount(4)
        ->and($cases[0])->toBe(UserType::SUPER_ADMINISTRATOR)
        ->and($cases[1])->toBe(UserType::ADMINISTRATOR)
        ->and($cases[2])->toBe(UserType::USER)
        ->and($cases[3])->toBe(UserType::GUEST);
});

test('super administrator has correct value', function () {
    expect(UserType::SUPER_ADMINISTRATOR->value)->toBe('super_administrator');
});

test('administrator has correct value', function () {
    expect(UserType::ADMINISTRATOR->value)->toBe('administrator');
});

test('user has correct value', function () {
    expect(UserType::USER->value)->toBe('user');
});

test('guest has correct value', function () {
    expect(UserType::GUEST->value)->toBe('guest');
});

test('super administrator label returns correct display name', function () {
    expect(UserType::SUPER_ADMINISTRATOR->label())->toBe('Super Administrator');
});

test('administrator label returns correct display name', function () {
    expect(UserType::ADMINISTRATOR->label())->toBe('Administrator');
});

test('user label returns correct display name', function () {
    expect(UserType::USER->label())->toBe('User');
});

test('guest label returns correct display name', function () {
    expect(UserType::GUEST->label())->toBe('Guest');
});

test('values returns all user type values as array', function () {
    $values = UserType::values();

    expect($values)->toBeArray()
        ->toHaveCount(4)
        ->toContain('super_administrator')
        ->toContain('administrator')
        ->toContain('user')
        ->toContain('guest');
});

test('options returns associative array of value to label mappings', function () {
    $options = UserType::options();

    expect($options)->toBeArray()
        ->toHaveCount(4)
        ->toHaveKey('super_administrator', 'Super Administrator')
        ->toHaveKey('administrator', 'Administrator')
        ->toHaveKey('user', 'User')
        ->toHaveKey('guest', 'Guest');
});

test('options can be used for select dropdowns', function () {
    $options = UserType::options();

    foreach ($options as $value => $label) {
        expect($value)->toBeString()
            ->and($label)->toBeString();
    }
});
