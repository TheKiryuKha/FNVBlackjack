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
        ->assertRedirectToRoute('games.destroy', $game);

    expect($game->fresh()->status)->toBe(GameStatus::CroupiersMove);

    expect($game->croupier->getPoints() >= 17)
        ->toBe(true);
});
