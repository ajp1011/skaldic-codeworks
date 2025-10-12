<?php

declare(strict_types=1);

use App\Enums\Theme;

test('has all expected cases', function () {
    $cases = Theme::cases();

    expect($cases)->toHaveCount(2)
        ->and($cases[0])->toBe(Theme::NORDIC_MINIMALISM)
        ->and($cases[1])->toBe(Theme::FORGECRAFT_MODERN);
});

test('nordic minimalism has correct value', function () {
    expect(Theme::NORDIC_MINIMALISM->value)->toBe('nordic-minimalism');
});

test('forgecraft modern has correct value', function () {
    expect(Theme::FORGECRAFT_MODERN->value)->toBe('forgecraft');
});

test('nordic minimalism slug returns correct value', function () {
    expect(Theme::NORDIC_MINIMALISM->slug())->toBe('nordic-minimalism');
});

test('forgecraft modern slug returns correct value', function () {
    expect(Theme::FORGECRAFT_MODERN->slug())->toBe('forgecraft');
});

test('nordic minimalism name returns correct display name', function () {
    expect(Theme::NORDIC_MINIMALISM->name())->toBe('Nordic Minimalism');
});

test('forgecraft modern name returns correct display name', function () {
    expect(Theme::FORGECRAFT_MODERN->name())->toBe('Forgecraft Modern');
});

test('nordic minimalism description returns correct text', function () {
    expect(Theme::NORDIC_MINIMALISM->description())
        ->toContain('Scandinavian')
        ->toContain('icy blue');
});

test('forgecraft modern description returns correct text', function () {
    expect(Theme::FORGECRAFT_MODERN->description())
        ->toContain('foundry')
        ->toContain('ember orange');
});

test('nordic minimalism css path returns correct value', function () {
    expect(Theme::NORDIC_MINIMALISM->cssPath())->toBe('./nordic-minimalism/nordic-minimalism.css');
});

test('forgecraft modern css path returns correct value', function () {
    expect(Theme::FORGECRAFT_MODERN->cssPath())->toBe('./forgecraft/forgecraft.css');
});

test('nordic minimalism effect path returns correct value', function () {
    expect(Theme::NORDIC_MINIMALISM->effectPath())->toBe('./snow-effect');
});

test('forgecraft modern effect path returns correct value', function () {
    expect(Theme::FORGECRAFT_MODERN->effectPath())->toBe('./spark-effect');
});

test('nordic minimalism text component returns correct value', function () {
    expect(Theme::NORDIC_MINIMALISM->textComponent())->toBe('CarvedText');
});

test('forgecraft modern text component returns correct value', function () {
    expect(Theme::FORGECRAFT_MODERN->textComponent())->toBe('ForgedText');
});

test('nordic minimalism particle container returns correct value', function () {
    expect(Theme::NORDIC_MINIMALISM->particleContainer())->toBe('snow-container');
});

test('forgecraft modern particle container returns correct value', function () {
    expect(Theme::FORGECRAFT_MODERN->particleContainer())->toBe('spark-container');
});

test('values returns all theme values as array', function () {
    $values = Theme::values();

    expect($values)->toBeArray()
        ->toHaveCount(2)
        ->toContain('nordic-minimalism')
        ->toContain('forgecraft');
});

test('options returns associative array of value to label mappings', function () {
    $options = Theme::options();

    expect($options)->toBeArray()
        ->toHaveCount(2)
        ->toHaveKey('nordic-minimalism')
        ->toHaveKey('forgecraft')
        ->and($options['nordic-minimalism'])->toBe('Nordic Minimalism')
        ->and($options['forgecraft'])->toBe('Forgecraft Modern');
});

test('options can be used for select dropdowns', function () {
    $options = Theme::options();

    foreach ($options as $value => $label) {
        expect($value)->toBeString()
            ->and($label)->toBeString();
    }
});

test('from slug returns correct theme for nordic minimalism', function () {
    $theme = Theme::fromSlug('nordic-minimalism');

    expect($theme)->toBe(Theme::NORDIC_MINIMALISM);
});

test('from slug returns correct theme for forgecraft', function () {
    $theme = Theme::fromSlug('forgecraft');

    expect($theme)->toBe(Theme::FORGECRAFT_MODERN);
});

test('from slug throws exception for invalid slug', function () {
    Theme::fromSlug('invalid-theme');
})->throws(ValueError::class);
