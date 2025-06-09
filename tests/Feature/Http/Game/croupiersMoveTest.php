<?php

declare(strict_types=1);

use App\Enums\GameStatus;
use App\Models\Game;
use App\Models\User;

test('change game status to croupiers move', function () {
    $user = User::factory()->create();
    $game = Game::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->from(route('games.show', $game))
        ->patch(route('games.croupiersMove', $game))
        ->assertStatus(200);

    expect($game->refresh()->status)
        ->toBe(GameStatus::CroupiersMove);
});
