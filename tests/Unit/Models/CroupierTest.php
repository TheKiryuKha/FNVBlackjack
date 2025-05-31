<?php

declare(strict_types=1);

use App\Models\Card;
use App\Models\Croupier;

test('to array', function () {
    $croupier = Croupier::factory()->create()->fresh();

    expect(array_keys($croupier->toArray()))->toBe([
        'id',
        'name',
        'created_at',
        'updated_at',
    ]);
});

it('has Cards', function () {
    $croupier = Croupier::factory()
        ->has(Card::factory(3), 'cards')
        ->create();

    expect($croupier->cards)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Card::class);
});
