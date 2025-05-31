<?php

declare(strict_types=1);

use App\Models\Card;
use App\Models\User;

test('to array', function () {
    $user = User::factory()->create()->fresh();

    expect(array_keys($user->toArray()))->toBe([
        'id',
        'name',
        'email',
        'chips',
        'chipsWon',
        'email_verified_at',
        'created_at',
        'updated_at',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
    ]);
});

it('has cards', function () {
    $user = User::factory()
        ->has(Card::factory(3), 'cards')
        ->create();

    expect($user->cards)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Card::class);
});
