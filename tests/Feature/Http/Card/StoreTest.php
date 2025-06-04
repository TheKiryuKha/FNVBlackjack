<?php

declare(strict_types=1);

use App\Models\Game;
use App\Models\User;

test('user get card', function () {
    $user = User::factory()->create();
    $game = Game::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->from(route('games.show', $game))
        ->post(route('cards.store', $game))
        ->assertRedirectToRoute('games.show', $game);

    expect($user->fresh()->cards)->toHaveCount(1);
});
