<?php

declare(strict_types=1);

use App\Models\Card;
use App\Models\Croupier;
use App\Models\Game;
use App\Models\User;

test('to array', function () {
    $game = Game::factory()->create()->fresh();

    expect(array_keys($game->toArray()))->toBe([
        'id',
        'user_id',
        'croupier_id',
        'bet',
        'status',
        'created_at',
        'updated_at',
    ]);
});

it('has cards', function(){
    $game = Game::factory()
        ->has(Card::factory(3))
        ->create();

    expect($game->cards)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Card::class);
});

it('belongs to croupier', function(){
    $game = Game::factory()
        ->for(Croupier::factory())
        ->create();

    expect($game->croupier)->toBeInstanceOf(Croupier::class);
});

it('belongs to user', function(){
    $game = Game::factory()
        ->for(User::factory())
        ->create();

    expect($game->user)->toBeInstanceOf(User::class);
});