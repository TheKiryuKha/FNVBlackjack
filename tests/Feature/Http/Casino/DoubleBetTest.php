<?php

declare(strict_types=1);

use App\Enums\GameStatus;
use App\Models\Game;
use App\Models\User;

test('user can double his test', function () {
    $user = User::factory()->create();
    $game = Game::factory()->create([
        'user_id' => $user->id,
        'bet' => 200,
    ]);

    $this->actingAs($user)
        ->from(route('game', $game))
        ->post(route('doubleBet', $game))
        ->assertRedirectToRoute('game', $game);

    expect($game->fresh())
        ->bet->toBe(400)
        ->status->toBe(GameStatus::CroupiersMove);

});
