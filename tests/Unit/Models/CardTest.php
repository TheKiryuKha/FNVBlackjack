<?php

declare(strict_types=1);

use App\Models\Card;
use App\Models\Croupier;
use App\Models\Game;
use App\Models\User;

test('to array', function () {
    $card = Card::factory()->create()->fresh();

    expect(array_keys($card->toArray()))->toBe([
        'id',
        'game_id',
        'owner_id',
        'owner_type',
        'type',
        'suit',
        'points',
        'created_at',
        'updated_at',
    ]);
});

it('belongs to user', function () {
    $card = Card::factory()
        ->for(User::factory(), 'owner')
        ->create();

    expect($card->owner)->toBeInstanceOf(User::class);
});

it('belongs to croupier', function () {
    $card = Card::factory()
        ->for(Croupier::factory(), 'owner')
        ->create();

    expect($card->owner)->toBeInstanceOf(Croupier::class);
});

it('belongs to game', function () {
    $card = Card::factory()
        ->for(Game::factory())
        ->create();

    expect($card->game)->toBeInstanceOf(Game::class);
});
