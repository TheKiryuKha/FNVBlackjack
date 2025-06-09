<?php

declare(strict_types=1);

use App\Enums\GameStatus;
use App\Models\Card;
use App\Models\Game;
use App\Models\User;

test('croupier takes cards', function () {
    $user = User::factory()->create();
    $game = Game::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->from(route('games.show', $game))
        ->post(route('croupier', $game))
        ->assertStatus(200);

    expect($game->croupier->cards)->toHaveCount(1);
});

test('croupier takes cards and game ends', function () {
    $user = User::factory()->create();
    $game = Game::factory()->create(['user_id' => $user->id]);
    Card::factory()->create([
        'owner_id' => $game->croupier->id,
        'owner_type' => 'croupier',
        'game_id' => $game->id,
        'points' => 10,
    ]);
    Card::factory()->create([
        'owner_id' => $game->croupier->id,
        'owner_type' => 'croupier',
        'game_id' => $game->id,
        'points' => 7,
    ]);

    $this->actingAs($user)
        ->from(route('games.show', $game))
        ->post(route('croupier', $game))
        ->assertStatus(200);

    expect($game->refresh()->status)->toBe(GameStatus::GameOver);

    expect($game->croupier->getPoints() >= 17)
        ->toBe(true);
});
