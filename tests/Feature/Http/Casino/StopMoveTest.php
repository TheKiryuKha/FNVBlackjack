<?php

declare(strict_types=1);

use App\Enums\GameStatus;
use App\Models\Game;
use App\Models\User;

test('user stops his move', function () {
    $user = User::factory()->create();
    $game = Game::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->from(route('game', $game))
        ->patch(route('stopMove', $game))
        ->assertRedirectToRoute('croupiersMove', $game);

    expect($game->fresh()->status)->toBe(GameStatus::CroupiersMove);
});
