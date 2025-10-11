<?php

declare(strict_types=1);

use App\Enums\UserType;
use App\Models\User;

test('is super administrator returns true for super admin user type', function () {
    $user = new User();
    $user->user_type = UserType::SUPER_ADMINISTRATOR;

    expect($user->isSuperAdministrator())->toBeTrue();
});

test('is super administrator returns false for other user types', function () {
    $userTypes = [
        UserType::ADMINISTRATOR,
        UserType::USER,
        UserType::GUEST,
    ];

    foreach ($userTypes as $type) {
        $user = new User();
        $user->user_type = $type;

        expect($user->isSuperAdministrator())->toBeFalse();
    }
});

test('is administrator returns true for administrator user type', function () {
    $user = new User();
    $user->user_type = UserType::ADMINISTRATOR;

    expect($user->isAdministrator())->toBeTrue();
});

test('is administrator returns false for other user types', function () {
    $userTypes = [
        UserType::SUPER_ADMINISTRATOR,
        UserType::USER,
        UserType::GUEST,
    ];

    foreach ($userTypes as $type) {
        $user = new User();
        $user->user_type = $type;

        expect($user->isAdministrator())->toBeFalse();
    }
});

test('is user returns true for user user type', function () {
    $user = new User();
    $user->user_type = UserType::USER;

    expect($user->isUser())->toBeTrue();
});

test('is user returns false for other user types', function () {
    $userTypes = [
        UserType::SUPER_ADMINISTRATOR,
        UserType::ADMINISTRATOR,
        UserType::GUEST,
    ];

    foreach ($userTypes as $type) {
        $user = new User();
        $user->user_type = $type;

        expect($user->isUser())->toBeFalse();
    }
});

test('is guest returns true for guest user type', function () {
    $user = new User();
    $user->user_type = UserType::GUEST;

    expect($user->isGuest())->toBeTrue();
});

test('is guest returns false for other user types', function () {
    $userTypes = [
        UserType::SUPER_ADMINISTRATOR,
        UserType::ADMINISTRATOR,
        UserType::USER,
    ];

    foreach ($userTypes as $type) {
        $user = new User();
        $user->user_type = $type;

        expect($user->isGuest())->toBeFalse();
    }
});

test('has admin privileges returns true for super administrator', function () {
    $user = new User();
    $user->user_type = UserType::SUPER_ADMINISTRATOR;

    expect($user->hasAdminPrivileges())->toBeTrue();
});

test('has admin privileges returns true for administrator', function () {
    $user = new User();
    $user->user_type = UserType::ADMINISTRATOR;

    expect($user->hasAdminPrivileges())->toBeTrue();
});

test('has admin privileges returns false for regular user', function () {
    $user = new User();
    $user->user_type = UserType::USER;

    expect($user->hasAdminPrivileges())->toBeFalse();
});

test('has admin privileges returns false for guest', function () {
    $user = new User();
    $user->user_type = UserType::GUEST;

    expect($user->hasAdminPrivileges())->toBeFalse();
});

test('fillable attributes include expected fields', function () {
    $user = new User();
    $fillable = $user->getFillable();

    expect($fillable)->toContain('name')
        ->toContain('email')
        ->toContain('password')
        ->toContain('user_type');
});

test('hidden attributes include password and remember token', function () {
    $user = new User();
    $hidden = $user->getHidden();

    expect($hidden)->toContain('password')
        ->toContain('remember_token');
});

test('casts include email verified at as datetime', function () {
    $user = new User();
    $casts = $user->getCasts();

    expect($casts)->toHaveKey('email_verified_at', 'datetime');
});

test('casts include password as hashed', function () {
    $user = new User();
    $casts = $user->getCasts();

    expect($casts)->toHaveKey('password', 'hashed');
});

test('casts include user type as UserType enum', function () {
    $user = new User();
    $casts = $user->getCasts();

    expect($casts)->toHaveKey('user_type', UserType::class);
});
