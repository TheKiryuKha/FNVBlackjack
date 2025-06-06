<?php

declare(strict_types=1);

use App\Enums\GameStatus;
use App\Models\Card;
use App\Models\Game;
use App\Models\User;
use App\Policies\GamePolicy;

test('game is over', function () {
    $policy = app(GamePolicy::class);
    $game = Game::factory()->create([
        'status' => GameStatus::GameOver,
    ]);

    expect($policy->isGameOver($game))->toBe(true);
});

test('is user has more Chips', function () {
    $policy = app(GamePolicy::class);
    $user = User::factory()->create();
    $game = Game::factory()->create(['user_id' => $user->id]);
    Card::factory()->count(3)->create([
        'owner_id' => $user->id,
        'owner_type' => 'user',
        'game_id' => $game->id,
        'points' => 10,
    ]);

    expect($policy->isUserHasMoreChips($user))->toBe(true);
});
