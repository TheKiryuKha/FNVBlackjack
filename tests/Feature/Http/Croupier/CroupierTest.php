<?php

declare(strict_types=1);

use App\Enums\GameStatus;
use App\Models\Game;
use App\Models\User;

test('croupier takes cards', function () {
    $user = User::factory()->create();
    $game = Game::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->from(route('games.show', $game))
        ->post(route('croupier', $game))
        ->assertRedirectToRoute('games.show', $game);

    expect($game->refresh()->status)->toBe(GameStatus::GameOver);

    expect($game->croupier->getPoints() >= 17)
        ->toBe(true);
});
