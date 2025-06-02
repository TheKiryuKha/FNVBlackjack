<?php

declare(strict_types=1);

use App\Enums\GameStatus;
use App\Models\Game;
use App\Models\User;

test('user starts the game', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->from(route('home'))
        ->post(route('startGame'), [
            'bet' => 100,
        ]);

    $response->assertRedirectToRoute('game');

    $game = Game::first();

    expect($game)
        ->user_id->toBe($user->id)
        ->bet->toBe(100)
        ->status->toBe(GameStatus::PlayersMove)
        ->cards->toHaveCount(3);

    expect($user->fresh()->cards)->toHaveCount(2);
    expect($game->croupier->cards)->toHaveCount(1);

});
