<?php

declare(strict_types=1);

use App\Enums\GameStatus;
use App\Models\Card;
use App\Models\Game;
use App\Models\User;

test('user can see his game page', function () {
    $user = User::factory()->create();
    $game = Game::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->get(route('games.show', $game))
        ->assertStatus(200);
});

test('user with more than 21 points redirects from show page', function () {
    $user = User::factory()->create();
    $game = Game::factory()->create(['user_id' => $user->id]);
    Card::factory()->count(3)->create([
        'owner_id' => $user->id,
        'owner_type' => 'user',
        'game_id' => $game,
        'points' => 10,
    ]);

    $this->actingAs($user)
        ->get(route('games.show', $game))
        ->assertRedirectToRoute('games.destroy', $game);
});

test('user redirects when croupiers move', function () {
    $user = User::factory()->create();
    $game = Game::factory()->create([
        'user_id' => $user->id,
        'status' => GameStatus::CroupiersMove,
    ]);

    $this->actingAs($user)
        ->get(route('games.show', $game))
        ->assertRedirectToRoute('croupier', $game);
});
