<?php

declare(strict_types=1);

use App\Enums\GameStatus;
use App\Models\Game;
use App\Models\User;

test('user can double his bet', function () {
    $user = User::factory()->create();
    $game = Game::factory()->create([
        'user_id' => $user->id,
        'bet' => 200,
    ]);

    $this->actingAs($user)
        ->from(route('games.show', $game))
        ->patch(route('games.update', $game))
        ->assertStatus(200);

    expect($game->fresh())
        ->bet->toBe(400)
        ->status->toBe(GameStatus::CroupiersMove);

});
